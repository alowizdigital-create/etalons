<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;
use Cake\Mailer\Mailer;


/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login','add','forgot','validsignup']);
    }

    public function login()
    {
        $this->viewBuilder()->setLayout('authentification');
        $this->request->allowMethod(['get', 'post']);
        $data =  $this->request->getData();
        if (!empty($data)) {
            $user = $this->Users->findByEmail($data['email'])->first();
            if (!$user) {
                return $this->Flash->error(__('Ce compte n\'existe pas.'));
            }
            if (!$user->is_active) {
                return $this->Flash->error(__('Confirmez votre adresse email pour continuer'));
            }
        }
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            // redirect to /articles after login success
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Users',
                'action' => 'dashboard',
            ]);
            return $this->redirect($redirect);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Mot de passe ou adresse mail invalide'));
        }
    }


    public function dashboard(){
        
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Users->find();
        $users = $this->paginate($query);
        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, contain: ['UserProfiles']);
        $this->set(compact('user'));
    }

    public function sendmail($token, $email)
    {
        // debug($token);die();
        $mailer = new Mailer();
        $mailer
            ->setEmailFormat('html')
            ->setTo($email)
            ->setSubject('Confirmer votre adresse email')
            ->setFrom('contact@taukwa.com')
            ->setViewVars([
                'token' => $token,
            ])
            ->viewBuilder()
                ->setTemplate('validcompte')
                ->setLayout('sympa');
        $mailer->deliver();
    }

    public function validsignup($token)  {
        $user = $this->Users->find()->where(['uuid'=>$token])->first();
        // debug($user);die();
        if (!$user || $user->token_expires < new \DateTime()) {
          return $this->redirect(['action' => 'obsolete', $user->email]);
        }
        $user->is_active = true;
        if ($this->Users->save($user)) {
            $this->Flash->success(__('Votre compte a été activé avec succès ! Entrez vos identifiants pour continuer.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
        return $this->redirect(['controller' => 'Users', 'action' => 'obsolete' ]);
    }


    public function validate($token)
    { 
        $user = $this->Users->find()->where(['uuid' => $token, 'is_active' => false])->first();
        if (!$user) {
            $this->Flash->error(__('Lien invalide ou compte déjà activé.'));
            return $this->redirect(['action' => 'login']);
        }
        // Activer le compte et creer un nouveau token
        $user->is_active = true;
        $user->uuid = text::uuid();
        $this->Users->save($user);
        $this->Flash->success(__('Votre compte a été activé avec succès ! Entrez vos identifiants pour continuer.'));
        return $this->redirect(['action' => 'login']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->setLayout('authentification');
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // debug($data);die();
            $email = $data['email'];
            $userexist = $this->Users->find()->where(['email'=>$email])->first();
            if(!empty($userexist)){
                $this->Flash->error(__('Un compte existe déjà avec cet adresse email.'));
                return $this->redirect(['action' => 'add']);
            }
            if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $data['password'])) {
                $this->Flash->error(__('Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule et un chiffre.'));
                return $this->redirect(['action' => 'add']);
            } 
            if (strlen($data['password']) < 8) {
                $this->Flash->error(__('Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule et un chiffre.'));
                return $this->redirect(['action' => 'add']);
            }
            // Vérification de l'email
            elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $this->Flash->error(__('Adresse email invalide.'));
                return $this->redirect(['action' => 'add']);
            }
            else {
            $user = $this->Users->patchEntity($user, $data);
            $token = text::uuid();
            $user->uuid =  $token;
            $user->token_expires = (new \DateTime())->modify('+3 hours');
            $email = $user->email;
            if ($this->Users->save($user)) {
                // $this->sendmail($token, $email);
                $email = $user->email;
                $profileTable =  $this->fetchTable('UserProfiles');
                $profile = $profileTable->newEmptyEntity();
                $profile->user_id = $user->id;
                $profile->email  = $user->email;
                $profile->uuid  = Text::uuid();
                $profileTable->save($profile);
                $this->Flash->success(__('Nous avons envoyé un lien de vérification à' . $email . '. Si vous ne le recevez pas dans les 5 minutes, veuillez vérifier votre dossier de courriers indésirables ou cliquer sur «Renvoyer»..'));
            }
            }
            // $this->Flash->error(__('Impossible de créer le compte. Veuillez réessayer.'));
        }
        $this->set(compact('user'));
    }


    public function logout()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    public function forgot()
    {
        $user = $this->Users->newEmptyEntity();
        $this->viewBuilder()->setLayout('authentification');
        if ($this->request->is('post','ajax'))
        {
            $data = $this->request->getData();
            $email = $data['email'];
            $psw1 = $data['password'];
            $psw2 = $data['password2'];
            $user = $this->Users->find()->where(['email'=>$email])->first();
            if(empty($user)){
                $this->Flash->error(__('Ce compte n\'existe pas.'));
            }
            if (strlen($data['password']) < 8)
            {
                $this->Flash->error(__('Le mot de passe doit contenir au moins 8 caractères.'));
            }
            elseif ($psw1 <> $psw2)
            {
                $this->Flash->error(__('Mot de passe non identique.'));
            }
            else
            {
            if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $data['password'])) {
                return  $this->Flash->error(__('Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule et un chiffre.'));
            } 
            $token = text::uuid();
            $user->uuid =  $token;
            $user->token_expires = (new \DateTime())->modify('+3 hours');
            // $this->ressetmail($token, $email);
            if ($this->Users->save($user)) {
                $email = $user->email;
                return    $this->Flash->success(__('Nous avons envoyé un lien de vérification à' . $email . '. Si vous ne le recevez pas dans les 5 minutes, veuillez vérifier votre dossier de courriers indésirables ou cliquer sur «Renvoyer»..'));
            }
            $this->Flash->error(__('Impossible de modifier le mot de passe, Veuillez réessayer.'));
            }
        }
        $this->set(compact('user'));
    }

    

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
