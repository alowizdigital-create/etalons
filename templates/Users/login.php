<?php
/**
 * Vue de la page de connexion (login.php)
 * Elle utilise le style défini dans le bloc <style> pour un affichage en deux colonnes,
 * en respectant la charte graphique AdvanceApp.
 */

// CORRECTION : Utiliser disableAutoLayout() pour désactiver correctement le layout
$this->disableAutoLayout();

// Commence la mise en page
?>

<!-- Bloc de styles pour cette vue spécifique -->
<style>
    /* Assure que la page prend 100% de la hauteur et supprime les marges/paddings par défaut */
    html, body {
        height: 100%;
        margin: 0 !important;
        padding: 0 !important;
        /* Force la disposition en colonne pour éviter les interférences si le layout est flex par défaut */
        display: flex;
        flex-direction: column; 
    }
    
    /* Variables pour les couleurs AdvanceApp */
    :root {
        --primary-color: #0d837c; /* Vert-Bleu Principal AdvanceApp */
        --background-color: #f8f9fa;
        --dark-blue: #235467; /* Bleu marine/foncé AdvanceApp (Couleur de la police du logo) */
        --input-bg: #f1f7fe;
        --text-color: #333;
    }
    
    .login-container {
        display: flex;
        width: 100%;
        /* Utilise 100% de la hauteur du viewport pour le conteneur principal */
        min-height: 100vh; 
    }

    /* Colonne Gauche (Visuel) */
    .visual-panel {
        flex: 1; 
        background-color: var(--dark-blue);
        /* Utilisation des couleurs de la charte AdvanceApp pour le dégradé */
        background-image: linear-gradient(135deg, #235467, #3c7d9e); 
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        /* Ajout d'un contenu simulé pour l'illustration */
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 2rem;
        text-align: center;
        padding: 20px;
    }
    .visual-content {
        /* Placeholder pour l'illustration */
        max-width: 80%;
    }
    .visual-content h1 {
        font-size: 1.5rem;
        font-weight: 300;
        margin-top: 20px;
    }
    .visual-content .icon-laptop {
        /* Style d'un SVG/icône de laptop stylisé */
        display: inline-block;
        font-size: 6rem;
        margin-bottom: 20px;
    }


    /* Colonne Droite (Formulaire) */
    .form-panel {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: white;
        padding: 40px 20px;
    }

    .form-content {
        max-width: 400px;
        width: 100%;
        text-align: left;
    }
    .logo { margin-bottom: 30px; }
    /* Style du logo AdvanceApp (bleu foncé) */
    .logo-text {
        font-size: 1.8rem;
        font-weight: bold;
        color: var(--dark-blue);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    /* Style de l'icône/symbole de AdvanceApp */
    .logo-symbol {
        /* Placeholder simple pour l'icône de chevrons */
        width: 30px;
        height: 30px;
        background: linear-gradient(45deg, #3c7d9e, #0d837c); /* Dégradé simple simulant l'icône */
        clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
    }

    h2 { 
        font-size: 1.5rem; 
        font-weight: 600; 
        margin-bottom: 10px; 
        line-height: 1.3; 
        color: #333; 
    }
    .welcome-text {
        font-size: 1rem;
        color: #777;
        margin-bottom: 40px;
    }

    /* Champs de saisie */
    label { display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 5px; color: #555; }
    .input-group { position: relative; margin-bottom: 25px; }
    .input-group input { 
        width: 100%; padding: 12px; padding-right: 40px; border: 1px solid #dee2e6;
        border-radius: 8px; /* Bords plus arrondis */
        background-color: var(--input-bg); 
        box-sizing: border-box; 
        font-size: 1rem;
        transition: border-color 0.3s;
    }
    .input-group input:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 2px rgba(13, 131, 124, 0.25); /* Utiliser la couleur primaire AdvanceApp */
    }


    /* Toggle Mot de passe */
    .password-toggle {
        position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #999;
    }

    /* Boutons et Liens */
    .form-actions { 
        display: flex; 
        justify-content: flex-end; /* Align the button to the right */
        align-items: center; 
        margin-top: 20px; 
    }
    .forgot-password { 
        color: #777; 
        text-decoration: none; 
        font-size: 0.9rem; 
        display: block;
        margin-top: 15px;
        font-weight: 500;
    }
    .forgot-password:hover {
        color: var(--primary-color);
    }
    .btn-proceed { 
        background-color: var(--primary-color); 
        color: white; 
        border: none; 
        padding: 10px 35px;
        border-radius: 8px; 
        cursor: pointer; 
        font-weight: 600; 
        transition: background-color 0.3s;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .btn-proceed:hover { background-color: #0a6560; } /* Teinte plus foncée au survol */

    /* Pied de page */
    .register-section { 
        text-align: center; 
        margin-top: 60px; 
        font-size: 0.9rem; 
        color: #777;
    }
    .register-section a { 
        color: var(--primary-color); 
        text-decoration: none; 
        font-weight: bold; 
        margin-left: 5px;
    }
    .windows-activation { 
        position: fixed; bottom: 10px; right: 10px; font-size: 0.8rem; color: #999; text-align: right; line-height: 1.3;
    }

    /* RESPONSIVITÉ MOBILE */
    @media (max-width: 992px) {
        .visual-panel { display: none; } /* Cache la colonne visuelle sur mobile */
        .form-panel { 
            flex: 0 0 100%; 
            padding: 40px 20px; 
            align-items: flex-start; /* Centre le formulaire verticalement pour les petits écrans */
        }
        .login-container { align-items: flex-start; }
    }
</style>

<!-- Début de la structure de la page -->
<div class="login-container">
    
    <!-- Colonne Gauche: Visuel/Illustration -->
    <div class="visual-panel">
        <div class="visual-content">
            <i class="fa-solid fa-laptop-code icon-laptop"></i> <!-- Icône de Font Awesome en remplacement de l'illustration complexe -->
            <h1>Bienvenue sur Taukwa</h1>
            <p style="font-size: 0.9rem; font-weight: 300; opacity: 0.8;">Votre plateforme d'envois de SMS  groupés ou programmés.</p>
        </div>
    </div>
    
    <!-- Colonne Droite: Formulaire de Connexion -->
    <div class="form-panel">
        <div class="form-content">
              <?= $this->Flash->render() ?>
            <!-- Logo et Textes d'Accueil -->
            <div class="logo">
                <span class="logo-text">
                    <div class="logo-symbol"></div>
                  Taukwa
                </span>
            </div>
            <h2>Bienvenue ! Connectez-vous à votre compte.</h2>
            <p class="welcome-text">Veuillez entrer vos identifiants pour continuer.</p>
            
            <!-- Affichage des messages Flash (si CakePHP) -->
            <?= $this->Flash->render() ?>

            <!-- Début du Formulaire CakePHP -->
            <?= $this->Form->create() ?>
                
                <!-- Champ Email -->
                <div class="input-group">
                    <!-- <label for="work-email">Email</label> -->
                    <?php echo $this->Form->control('email',['']); ?>
                    <!-- <input type="email" id="work-email" name="email" placeholder="votre.email@taukoa.com" required> -->
                </div>

                <!-- Champ Mot de Passe -->
                <div class="input-group">
                    <label for="password">Mot de Passe</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                    <span class="password-toggle" id="togglePassword">
                        <i class="fa-solid fa-eye-slash"></i>
                    </span>
                </div>
                
                <!-- Section Mot de Passe Oublié et Bouton de Connexion -->
                <div class="form-actions">
                    <!-- Note: Le lien Mot de passe oublié est souvent placé ici à gauche du bouton dans ce type de design, mais je le place sous le champ pour plus de clarté pour l'utilisateur -->
                </div>
                <a href="#" class="forgot-password">Mot de passe oublié ?</a>

                <div class="form-actions" style="justify-content: flex-end;">
                     <button type="submit" class="btn-proceed">Continuer</button>
                </div>
                
            <?= $this->Form->end() ?>

            <!-- Section Création de Compte -->
            <div class="register-section">
                Pas de compte Taukwa ? 
                <a href="/users/add">Créez un compte ici !</a>
            </div>
             <div class="register-section">
                <a href="/users/forgot">Mot de passe oublié ? </a>
            </div>

            <!-- Activation Windows (bas de page) -->
            <div class="windows-activation">
                Activer Windows<br>
                Accédez aux Paramètres pour activer Windows.
            </div>

        </div>
    </div>
    
</div>

<!-- Script pour basculer l'affichage du mot de passe -->
<script>
    document.getElementById('togglePassword').addEventListener('click', function (e) {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Basculer l'icône de l'œil
        const icon = this.querySelector('i');
        if (type === 'text') {
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    });

    // Optionnel: Empêcher le body de défiler si le layout global le permet
    document.body.style.overflow = 'hidden';
</script>
