<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contact $contact
 */
?>
<div class="wrapper" style="margin-top: 74px;">
<!-- <div class="content-wrapper"> -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title"><?= __('Ajouter un contact') ?></h3>
  </div>
  
  <div class="card-body">
    <?= $this->Form->create($company) ?>
    <div class="form-group">
        <?= $this->Form->control('name', [
        'label' => 'Nom',
        'class' => 'form-control',
        'placeholder'=>'Ex: APON SARL'
      ]) ?>
      <?= $this->Form->control('code', [
        'label' => 'Sigle',
        'class' => 'form-control',
        'placeholder'=>'Ex: THDG YH'
      ]) ?>
      <?= $this->Form->control('city', [
        'label' => 'Ville',
        'class' => 'form-control',
        'placeholder'=>'Ex: Yaounde'
      ]) ?>
      <?= $this->Form->control('manager', [
        'empty'=>true,
        'label' => "Gestionnaire",
        'class' => 'form-control',
        'placeholder'=>'Ex: Atangana paul'
      ]) ?>
       <?= $this->Form->control('phone', [
        'empty'=>true,
        'label' => "Téléphone",
        'class' => 'form-control',
        'placeholder'=>'Ex: 656262480'
      ]) ?>
       <?= $this->Form->control('email', [
        'empty'=>true,
        'label' => "Email",
        'class' => 'form-control',
        'placeholder'=>'Ex: exemple@gmail.com'
      ]) ?>

    </div>
  </div>
  <div class="card-footer">
    <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
  </div>
</div>
</div>
