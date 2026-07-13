<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;
use DateTime;

use App\Model\Entity\Reminder;
use App\Model\Entity\User;
use App\Model\Entity\Vehicle;
use Cake\I18n\Date;
use Cake\Mailer\Mailer;
use Cake\I18n\FrozenTime;
use Cake\Routing\Router;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\Http\Client; 

/**
 * CalibrationRecords Controller
 *
 * @property \App\Model\Table\CalibrationRecordsTable $CalibrationRecords
 */
class CalibrationRecordsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->CalibrationRecords->find()
            ->contain(['Devices', 'Companies', 'Agents']);
        $calibrationRecords = $this->paginate($query);
        $this->set(compact('calibrationRecords'));
    }

    /**
     * View method
     *
     * @param string|null $id Calibration Record id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
     
     
    public function view($id = null)
    {
        $calibrationRecord = $this->CalibrationRecords->get($id, contain: ['Devices', 'Companies', 'Agents', 'Messages']);
        $this->set(compact('calibrationRecord'));
    }
    
    
    //   La methode de gestion des etats des appareils des entreprises , affiche le
    //   nombre des appareils des entreprises en fonctions de recherche

    public function state()
    {
        
        $query = $this->CalibrationRecords->find()
               ->contain(['Devices', 'Companies', 'Agents']);
    
        $companyId   = $this->request->getQuery('search');   // entreprise
        $deviceName  = $this->request->getQuery('search2');  // device
        $from        = $this->request->getQuery('from');
        $to          = $this->request->getQuery('to');
        
        $companyName = '';
        
       
        /* ===============================
         * FILTRE ENTREPRISE
         * =============================== */
        if (!empty($companyId)) {
            $query->where([
                'Companies.id' => $companyId
            ]);
            
             $company =  $this->fetchTable('Companies')->find()->where(['id'=>$companyId])->first();
             $companyName = $company->name ??'';
            //     debug($companyName);
            //   die();
        }
      
       
        /* ===============================
         * FILTRE DEVICE (LE POINT CLÉ)
         * =============================== */
         
        if (!empty($deviceName)) {
    
            $query
                ->leftJoinWith('Devices')
                ->andWhere([
                    'Devices.name LIKE' => '%' . $deviceName . '%'
                ]);
        }
    
        /* ===============================
         * FILTRE DATES
         * =============================== */
        if (!empty($from)) {
            $query->andWhere([
                'CalibrationRecords.calibration_date >=' => $from
            ]);
        }
    
        if (!empty($to)) {
            $query->andWhere([
                'CalibrationRecords.calibration_date <=' => $to
            ]);
        }
    
        /* ===============================
         * TRI
         * =============================== */
        $query->orderBy([
            'Companies.name' => 'ASC',
            'CalibrationRecords.calibration_date' => 'ASC'
        ]);
    
        /* ===============================
         * EXECUTION
         * =============================== */
        $records = $query->all();
    
        /* ===============================
         * REGROUPEMENT PAR ENTREPRISE
         * =============================== */
        $data = [];
    
        foreach ($records as $r) {
            if (empty($r->company)) {
                continue;
            }
    
            $companyId = $r->company->id;
    
            if (!isset($data[$companyId])) {
                $data[$companyId] = [
                    'company' => $r->company,
                    'records' => [],
                    'total' => 0
                ];
            }
            if (isset($r->price)) {
                $data[$companyId]['total'] += $r->price;
            }
    
            $data[$companyId]['records'][] = $r;
        }
        // debug($companyName);
        // die();
    
        $companies = $this->fetchTable('Companies')->find('list', limit: 200)->all();
        $this->set(compact('data', 'from', 'to', 'companies','deviceName','companyName'));
    }



    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
     

     public function add()
    {
        $calibrationRecord = $this->CalibrationRecords->newEmptyEntity();
        if ($this->request->is('post')) {
            $calibrationRecord = $this->CalibrationRecords->patchEntity($calibrationRecord, $this->request->getData());
            $calibrationRecord->uuid = Text::uuid();
            $calibrationRecord->create_uid = $this->currentUser->id;
            $calibrationRecord->certificat_number = $this->request->getData('certificat_number');
            $calibrationRecord->location = $this->request->getData('location');
            $calibrationRecord->write_uid = $this->currentUser->id;
            $calibrationRecord->amount = $this->request->getData('amount');
            
            $lastVisitDate = $this->request->getData('date');
            if ($lastVisitDate) {
                $lastVisitDate = new DateTime($lastVisitDate);
                $endAndSentDate = ($lastVisitDate)->modify('+90 days');
            }else{
                $endAndSentDate =  (new DateTime())->modify('+90 days');
            }
            // debug($calibrationRecord);die();
            $validity = $calibrationRecord->validity;
            $calibration_date = $calibrationRecord->calibration_date;

            if(is_null($calibration_date))
            {
                $calibration_date = new DateTime();
                // debug($calibration_date);die();
            }
            $calibrationRecord->calibration_date = $calibration_date;
            // debug($calibration_date);die();
            
            $nbr_month = (int)$validity;
            $calibrationRecord->next_calibration_date = $calibration_date->modify("+{$nbr_month} months");

                $device =  $this->fetchTable('Devices')->find()->where(['id'=>$calibrationRecord->device_id])->first();
                $company =  $this->fetchTable('Companies')->find()->where(['id'=>$calibrationRecord->company_id])->first();
                $email = $company->email;
                // 9. MESSAGES DE RELANCE (Définition des variables de remplacement)
            // $Messages = $this->fetchTable('Messages'); $this->request->getData('certificat_number');

            $replacements = [
                '[Marque]'=> $device->manufacturer ?? '',
                '[numCertificat]' =>  $this->request->getData('certificat_number') ?? '',
                '[NomAppareil]' => $device->name ?? '',
                '[numSerie]' =>  $device->serea_number ?? '',
                '[calibrationDate]' => $calibration_date??'',
                '[city]' => $this->request->getData('location')??'',
                '[startupName]' => $company->name ?? '',
                '[deviceName]' =>  $device->name ?? '',
                '[expireDate]' =>  $calibrationRecord->next_calibration_date ?? '',
            ];

            // Verification de numero mtn ou orange

            $recipient = $company->phone;
            // debug($recipient);die();
            $thisStatupData =  'CCT GODWIN';

            //     1. Nettoyage et extraction des 3 premiers chiffres (le préfixe complet)
            if ($thisStatupData == 'CCT GODWIN')
                {
                    
                $cleanedNumber = preg_replace('/[^0-9]/', '', $recipient);
                // debug($cleanedNumber);die();

                // On s'assure qu'il s'agit bien d'un numéro mobile (9 chiffres, commence par 6)
                if (strlen($cleanedNumber) !== 9 || !str_starts_with($cleanedNumber, '6')) {
                            $this->Flash->error(__('Format de numéro invalide ou inconnu.'));
                }
                
                // Récupère les trois premiers chiffres : '653', '699', '677', etc.
                $fullPrefix = substr($cleanedNumber, 0, 3);
                $operateur = 'Inconnu';

                // 2. Logique d'identification (basée sur les trois premiers chiffres)
                
                // --- BLOCS MTN ---
                // Liste des préfixes MTN (67X, 680-683, 650-654)
                if (str_starts_with($fullPrefix, '67') || 
                    ($fullPrefix >= '680' && $fullPrefix <= '683') ||
                    ($fullPrefix >= '650' && $fullPrefix <= '654')
                ) {
                    $operateur = 'MTN';
                }
                
                // --- BLOCS ORANGE ---
                // Liste des préfixes Orange (69X, 686-689, 655-659)
                elseif (str_starts_with($fullPrefix, '69') || 
                    ($fullPrefix >= '686' && $fullPrefix <= '689') ||
                    ($fullPrefix >= '655' && $fullPrefix <= '659')
                ) {
                    $operateur = 'Orange';
                }
                
                // --- ENREGISTREMENT DU MESSAGE DE REMERCIEMENT (HORS BOUCLE) ---
            
                if ($operateur == 'Orange')
                {
                    $thankYouContent = 'Cher client, l étalonnage de votre appareil: [NomAppareil] a été bien enregistré Nous vous remercions pour votre confiance.';
                }else {
                    $thankYouContent = 'Cher client, l étalonnage de votre appareil: [NomAppareil] a été bien enregistré Nous vous remercions pour votre confiance.';
                }
            }else {
                $thankYouContent = 'Cher client, merci pour la visite technique de votre véhicule [immatriculation]. Nous apprécions votre confiance.';
            }
            
            $sheduleContent = "Cher client, [startupName] l'étalonnage de votre appareil: [deviceName] expire le : [expireDate]. Bien vouloir penser à le renouveler.";
            // $thankYouContent = 'Cher client, merci pour la visite technique de votre véhicule [immatriculation]. Nous apprécions votre confiance.';
        
            
            // Templates pour les emails de  relances DIFFÉRÉES (sans le remerciement)
            $messageTemplates = [
                // Message 1: 7 jours avant l'expiration
                [
                    'content' => "Cher partenaire, le certificat d'étalonnage numéro [numCertificat] de votre [deviceName] de marque [Marque] numéro de series [numSerie] etalonné en date du [calibrationDate] dans la ville de [city] arrive à expiration le [expireDate]. Merci de le renouveler.",
                    'offset' => '-14 days',
                ],
                // Message 2: 3 jours avant l'expiration
                [
                      'content' => "Cher partenaire, le certificat d'étalonnage numéro [numCertificat] de votre [deviceName] de marque [Marque] numéro de series [numSerie] etalonné en date du [calibrationDate] dans la ville de [city] arrive à expiration le [expireDate]. Merci de le renouveler.",
                    'offset' => '-7 days',
                ],
                // Message 3: Le jour de l'expiration
                [
                     'content' => "Cher partenaire, le certificat d'étalonnage numéro [numCertificat] de votre [deviceName] de marque [Marque] numéro de series [numSerie] etalonné en date du [calibrationDate] dans la ville de [city] arrive à expiration le [expireDate]. Merci de le renouveler.",
                     'offset' => '-3 days',
                ],
            ];

            // 10. ENREGISTREMENT DES RELANCES DIFFÉRÉES (Boucle)
            foreach ($messageTemplates as $template) {
                $finalContent = str_replace(array_keys($replacements), array_values($replacements), $template['content']);
                $message = $this->fetchTable('Messages')->newEmptyEntity();
                $message->content = $finalContent;
                $message->status = 'pending';
                // $message->receiver = $customer->phone;
                $message->email = $email;
                $message->calibration_record_id = 4;
                if ($template['offset'] !== null) {
                    // Calcul basé sur le décalage (J-14 ou J-3)
                    // Utilisation de FrozenTime pour la manipulation de date dans CakePHP
                    $message->sent_date = (new FrozenTime($calibrationRecord->next_calibration_date))->modify($template['offset']); 
                } 
                $message->create_uid = $this->currentUser->id;
                $message->write_uid = $this->currentUser->id;
                $message->uuid = Text::uuid();
                $message->email = $company->email;
                $message->receiver = $recipient;
              
                $this->fetchTable('Messages')->save($message); 
            }

            // debug('test');die();

            $finalThankYouContent = str_replace(array_keys($replacements), array_values($replacements), $thankYouContent);
            // debug($finalThankYouContent);die();
            $content= $finalThankYouContent;
            $startupName = 'CCT GODWIN';
            $email = $company->email;
            $branding = $device->manufacturer;
            $serea_num = $device->serea_number;
            $device = $device->name;
            // debug($device);
            // die();
           
            $calibartion_date = $calibration_date;
            $location = $this->request->getData('location');

            $this->sendmail($device,$location,$calibartion_date,$serea_num,$branding, $email);
            // $this->sendSms($recipient,$content,$startupName,$operateur ?? '');

            if ($this->CalibrationRecords->save($calibrationRecord)) {
                $this->Flash->success(__('The record has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The calibration record could not be saved. Please, try again.'));
        }
        $devices = $this->CalibrationRecords->Devices->find('list', limit: 200)->all();
        $companies = $this->CalibrationRecords->Companies->find('list', limit: 200)->all();
        $agents = $this->CalibrationRecords->Agents->find('list', limit: 200)->all();
        $this->set(compact('calibrationRecord', 'devices', 'companies', 'agents'));
    }
    
    

    public function sendmail($device,$location,$calibartion_date,$serea_num,$branding, $email)
    {
        // debug($email);die();
        $mailer = new Mailer();
        $mailer
            ->setEmailFormat('html')
            ->setTo($email)
            ->setSubject('LABOGENIE : Etalonnage enregistré')
            ->setFrom(['contact@taukwa.com' => 'LABOGENIE'])
            ->setViewVars([
               'device' => $device,'location'=>$location,'calibartion_date'=>$calibartion_date,'serea_num' => $serea_num , 'branding'=>$branding
            ])
            ->viewBuilder()
                  ->setTemplate('thank')
                ->setLayout('thank');
        $mailer->deliver();
    }

       public function sendSms($recipient,$content,$startupName,$operateur)
      {
         // 🚨 CONFIGURATION DE TEST (REMPLACEZ PAR VOS VALEURS RÉELLES) 🚨
        $apiKey    = '4IlrXpZRlqp4bLOdjnBCyS6qk68uleWE7ttHRsOyJF7ydOH97Ti6H7llfmDicjdNbuY2';
        $endpoint  = 'https://api.avlytext.com/v1/sms';
        $chaine_reduite = substr($startupName, 0, 11);
        // debug($content);die();

        // if (condition) {
        //    $sender  =  'DosSMS';
        //    $recipient = '+237' .''. 653321288;
        // }else {
        //    $sender =  $chaine_reduite;
        //     $recipient = '+237' .''. 653321288;
        // }

        // $sender =  'CCT GODWIN';
        if (!is_null($operateur)||!empty($operateur))
        {
            if ($operateur == 'MTN') {
            $sender  =  'LABOGENIE';
            }else{
            $sender  =  'LABOGENIE';
            }
        }else
        {
            $sender  =  'LABOGENIE';
        }
      
        // debug($sender);die();
       
        $recipient = '+237' .''. $recipient;
        $text      = $content;
        // debug($recipient);die();
        try {
            // 1. Initialisation du Client HTTP (simule la commande curl)
            $http = new Client();

            // 2. Préparation de l'URL avec la clé API en Query Parameter
            $urlWithKey = $endpoint . '?api_key=' . urlencode($apiKey);
             
            // 3. Définition des données JSON (pour le --data)
            $data = [
                'sender' => $sender,
                'recipient' => $recipient,
                'text' => $text,
            ];
            
            // 4. Options pour le Header et la redirection
            $options = [
                'redirect' => true,      // Simule --location
                'type' => 'json',        // Simule --header 'Content-Type: application/json'
            ];
            // debug($recipient);die();

            // 5. Exécution de la requête POST
            $response = $http->post(
                $urlWithKey, 
                $data, 
                $options
            );
            if ($response->isOk()) {
                $apiResponse = $response->getJson();
                //  debug($apiResponse);die();
                // $this->Flash->success('✅ SMS envoyé avec succès! Statut API: ' . h($apiResponse['status']));
            } else {
                // $this->Flash->error('❌ Échec de l\'envoi. Code HTTP: ' . $response->getStatusCode());
                // $this->Flash->error('Réponse API: ' . $response->getStringBody());
            }
        
        } catch (\Exception $e) {
          
        }
    }


    /**
     * Edit method
     *
     * @param string|null $id Calibration Record id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    
    public function edit($id = null)
    {
        $calibrationRecord = $this->CalibrationRecords->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $calibrationRecord = $this->CalibrationRecords->patchEntity($calibrationRecord, $this->request->getData());
            if ($this->CalibrationRecords->save($calibrationRecord)) {
                $this->Flash->success(__('The calibration record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The calibration record could not be saved. Please, try again.'));
        }
        $devices = $this->CalibrationRecords->Devices->find('list', limit: 200)->all();
        $companies = $this->CalibrationRecords->Companies->find('list', limit: 200)->all();
        $agents = $this->CalibrationRecords->Agents->find('list', limit: 200)->all();
        $this->set(compact('calibrationRecord', 'devices', 'companies', 'agents'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Calibration Record id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $calibrationRecord = $this->CalibrationRecords->get($id);
        if ($this->CalibrationRecords->delete($calibrationRecord)) {
            $this->Flash->success(__('Enregistrement supprimé'));
        } else {
            $this->Flash->error(__('The calibration record could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}