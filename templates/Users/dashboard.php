<?php
/**
 * Vue du tableau de bord (Dashboard) inspirée du modèle fourni (Métriques SMS),
 * utilisant la charte graphique AdvanceApp.
 * Cette vue est conçue pour être utilisée AVEC le layout principal (AdminLTE).
 */

// Définition des variables de la charte AdvanceApp
$primaryColor = '#0d837c'; // Vert-Bleu
$darkColor = '#235467'; // Bleu Foncé
$secondaryColor = '#3c7d9e'; // Un bleu intermédiaire pour certains éléments

// Données de simulation (à remplacer par vos données CakePHP réelles)
$totalSms = 72;
$smsToday = 6;
$smsMonthly = 72;
$balance = 13.426;
$deliveryRate = 83; // Pourcentage
$pendingRate = 17; // Pourcentage
$failedRate = 0; // Pourcentage

// Configuration des titres et liens si nécessaire pour le layout
$this->assign('title', 'Tableau de Bord');
?>

<!-- Styles CSS spécifiques pour les cartes et les éléments de la charte AdvanceApp -->
<style>
    /* Variables de Couleurs pour cohérence */
    :root {
        --aa-primary: <?= $primaryColor ?>; 
        --aa-dark: <?= $darkColor ?>;
        --aa-secondary: <?= $secondaryColor ?>;
    }
    
    .content-wrapper {
        background-color: #f8f9fa !important;
    }

    /* Styles pour la section des métriques (nouvelle structure de "info-box") */
    .metric-box {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        padding: 15px;
        text-align: center;
        margin-bottom: 20px;
        border: 1px solid #e9ecef;
    }
    .metric-box h5 {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 5px;
    }
    .metric-box p {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--aa-dark);
        line-height: 1.2;
    }
    /* Solde en couleur primaire */
    .metric-box.balance-metric p {
        color: var(--aa-primary);
    }
    /* Carte d'information globale */
    .info-card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid #e9ecef;
        margin-bottom: 20px;
        background-color: white;
        padding: 20px;
    }

    /* Performances du trafic (grande métrique + barres) */
    .traffic-metric {
        font-size: 3rem;
        font-weight: 700;
        color: var(--aa-primary);
    }
    .progress-bar-container {
        display: flex;
        width: 100%;
        height: 10px;
        border-radius: 5px;
        overflow: hidden;
    }
    .progress-bar-segment {
        height: 100%;
        text-align: center;
        color: white;
        font-weight: bold;
        transition: width 0.6s ease;
    }
    .delivered-text { color: var(--aa-primary); font-weight: 600; }
    .pending-text { color: var(--aa-secondary); font-weight: 600; }
    .failed-text { color: #dc3545; font-weight: 600; }

    /* Graphique et Groupes de contacts (section inférieure) */
    .chart-box {
        min-height: 350px;
        /* Placeholder pour le graphique */
        background: linear-gradient(to top right, #f0f0f0, #ffffff);
        border: 1px dashed #ccc;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 0.9rem;
        color: #777;
    }
    .contact-groups-box {
        padding-left: 30px;
    }
    .contact-groups-box h3 {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--aa-dark);
        margin-bottom: 5px;
    }
    .contact-groups-box p {
        font-size: 1rem;
        color: #6c757d;
        margin-bottom: 15px;
    }

    /* Styles pour la carte de droite (qui devient maintenant pleine largeur) */
    .section-card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid #e9ecef;
        margin-bottom: 20px;
        background-color: white;
    }
    .card-header-icon {
        color: var(--aa-primary);
        margin-right: 5px;
    }
    .card-title {
        font-weight: 600;
        color: var(--aa-dark);
        font-size: 1.1rem;
    }
    /* Les styles key-box et url-box ne sont plus nécessaires car l'API key est supprimée */
    .key-box, .url-box {
        background-color: #f8f9fa; 
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 10px;
        font-family: monospace;
        font-size: 0.9rem;
        color: #555;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .copy-btn {
        background: none;
        border: none;
        color: var(--aa-primary);
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 500;
        margin-left: 10px;
        padding: 0;
    }
</style>


<div class="content">
    <div class="container-fluid">
        
        <!-- EN-TÊTE PRINCIPAL (Dashboard Title & Recharge Button) -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="m-0" style="font-weight: 700; color: var(--aa-dark);">Dashboard</h1>
            <div class="d-flex align-items-center">
                <span class="mr-3" style="font-weight: 600; color: var(--aa-dark);">Crédits <span style="color: var(--aa-primary);">$<?= number_format($balance, 3, ',', ' ') ?></span></span>
                <button class="btn btn-sm" style="background-color: var(--aa-primary); color: white; border-radius: 8px;">
                    <i class="fas fa-redo-alt mr-1"></i> Recharger
                </button>
            </div>
        </div>
        <p class="text-muted mb-4">* Remarque : Les valeurs du dashboard sont générées à partir des données des 90 derniers jours</p>

        <div class="row">
            
            <!-- Colonne Principale (Maintenant pleine largeur: col-12) -->
            <div class="col-12">
                
                <!-- 1. Section des Métriques Principales (Total SMS, Aujourd'hui, Mensuel, Solde) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="metric-box">
                            <h5>Total de SMS</h5>
                            <p><?= $totalSms ?></p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="metric-box">
                            <h5>SMS d'aujourd'hui</h5>
                            <p><?= $smsToday ?></p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="metric-box">
                            <h5>SMS mensuels</h5>
                            <p><?= $smsMonthly ?></p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="metric-box balance-metric">
                            <h5>Solde</h5>
                            <p>$<?= number_format($balance, 3, ',', ' ') ?></p>
                        </div>
                    </div>
                </div> <!-- /.row des métriques -->

                <!-- 2. Section Performances du trafic d'aujourd'hui -->
                <div class="info-card">
                    <h4 style="font-weight: 600; color: var(--aa-dark); margin-bottom: 20px;">Performances du trafic d'aujourd'hui</h4>
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <span class="traffic-metric"><?= $smsToday ?></span>
                            <p class="text-muted">SMS</p>
                        </div>
                        <div class="col-md-10">
                            <div class="row mb-2">
                                <div class="col text-center">
                                    <span class="pending-text"><?= $pendingRate ?>%</span>
                                    <div class="text-muted">En traitement</div>
                                </div>
                                <div class="col text-center">
                                    <span class="delivered-text"><?= $deliveryRate ?>%</span>
                                    <div class="text-muted">Délivré</div>
                                </div>
                                <div class="col text-center">
                                    <span class="failed-text"><?= $failedRate ?>%</span>
                                    <div class="text-muted">Échoué</div>
                                </div>
                            </div>
                            <!-- Barre de progression segmentée -->
                            <div class="progress-bar-container">
                                <div class="progress-bar-segment bg-info" style="width: <?= $pendingRate ?>%; background-color: <?= $secondaryColor ?>;"></div>
                                <div class="progress-bar-segment bg-success" style="width: <?= $deliveryRate ?>%; background-color: <?= $primaryColor ?>;"></div>
                                <div class="progress-bar-segment bg-danger" style="width: <?= $failedRate ?>%; background-color: #dc3545;"></div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /.info-card Performances -->


                <!-- 3. Section Trafic SMS hebdomadaire & Groupes de contacts -->
                <div class="info-card">
                    <div class="row">
                        <!-- Graphique (Gauche 8/12) -->
                        <div class="col-md-8">
                            <h4 style="font-weight: 600; color: var(--aa-dark);">Trafic SMS hebdomadaire</h4>
                            <p class="text-muted mb-3">Statistiques SMS des 7 derniers jours</p>
                            <div class="chart-box">
                                <!-- Placeholder pour le graphique (courbes et barres) -->
                                <i class="fas fa-chart-area mr-2"></i> Placeholder pour le graphique (Intégrer Chart.js ou autre ici)
                            </div>
                        </div>
                        <!-- Groupes de contacts (Droite 4/12) -->
                        <div class="col-md-4 border-left">
                            <div class="contact-groups-box">
                                <h4 style="font-weight: 600; color: var(--aa-dark); margin-bottom: 25px;">Groupes de contacts</h4>
                                
                                <h3 style="color: var(--aa-dark);">0</h3>
                                <p>Groupes</p>
                                <h3 style="color: var(--aa-primary);">0</h3>
                                <p>Contacts</p>
                            </div>
                        </div>
                    </div>
                </div> <!-- /.info-card Trafic -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>

<!-- Fonction JavaScript pour copier dans le presse-papiers (ces boutons ne sont plus utilisés, mais la fonction est conservée au cas où) -->
<script>
    function copyToClipboard(text, fieldName) {
        // Crée un élément temporaire pour copier le texte
        const tempInput = document.createElement('textarea');
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        
        try {
            document.execCommand('copy');
            console.log(`Le champ "${fieldName}" a été copié.`);
            // Vous pouvez ajouter ici un petit message de confirmation à l'utilisateur si vous le souhaitez
        } catch (err) {
            console.error('Impossible de copier le texte : ', err);
        }
        
        document.body.removeChild(tempInput);
    }
</script>
