<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contact $contact
 */
?>
<div class="wrapper" style="">
<!-- <div class="content-wrapper"> -->
<div class="card">
  <div class="card-header">
      <h3 class="card-title"><?= __("FICHE D'ETALONNAGE") ?></h3>
  </div>
  <div class="card-body">
     <?= $this->Form->create($calibrationRecord) ?>
    <div class="form-group">
       
      <?= $this->Form->control('device_id', [
                        'options'=> $devices,
                        'label' => 'Equipement',
                        'required'=> true,
                        'class' => 'form-control'
                    ]); ?>
      <?= $this->Form->control('company_id', [
                        'options'=> $companies,
                        'required'=> true,
                        'label'=>'Entreprise',
                        'class'=>'form-control'
                    ]); ?>
      <?= $this->Form->control('agent_id', [
                        'options'=> $agents,
                        'required'=> true,
                        'label'=>'Agent',
                        'class'=>'form-control'
                    ]); ?>
                     <?= $this->Form->control('validity', [
                        'label' => 'Validité',
                        'type'=> 'number',
                        'required'=> true,
                        'class' => 'form-control',
                        'placeholder' => 'Ex : 12 mois'
                    ]); ?>
      <?= $this->Form->control('calibration_date', [
                    "label"=>"Date d'étalonnage",
                    'required'=> true,
                    'class'=>'form-control'
                ]); ?>
       <?= $this->Form->control("location", [
                "label"=>"Lieu d'intervention",
                'required'=> true,
                'class'=>'form-control'
            ]); ?>
              <?= $this->Form->control("certificat_number", [
                "label"=>"Numéro du certificat",
                'required'=> true,
                'class'=>'form-control'
            ]); ?>
        <?= $this->Form->control("amount", [
                "label"=>"Montant",
                // 'required'=> true,
                'class'=>'form-control'
            ]); ?>
    </div>
  </div>
  <div class="card-footer">
    <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
  </div>
</div>
</div>
