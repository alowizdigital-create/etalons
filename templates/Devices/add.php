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
    <?= $this->Form->create($device) ?>
    <div class="form-group">
        <?= $this->Form->control('name', [
        'label' => 'Nom',
        'class' => 'form-control',
        'placeholder'=>'Ex: apon '
      ]) ?>
      <?= $this->Form->control('device_code', [
        'label' => 'Code appareil ',
        'class' => 'form-control',
        'placeholder'=>'Ex: LABOAPP0001'
      ]) ?>
      <?= $this->Form->control('manufacturer', [
        'label' => 'Fabricant',
        'class' => 'form-control',
        'placeholder'=>'Ex: SETAL'
      ]) ?>
    </div>
  </div>
  <div class="card-footer">
    <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
  </div>
</div>
</div>
