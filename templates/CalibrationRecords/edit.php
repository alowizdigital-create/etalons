<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CalibrationRecord $calibrationRecord
 * @var string[]|\Cake\Collection\CollectionInterface $devices
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $agents
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $calibrationRecord->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $calibrationRecord->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Calibration Records'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="calibrationRecords form content">
            <?= $this->Form->create($calibrationRecord) ?>
            <fieldset>
                <legend><?= __('Edit Calibration Record') ?></legend>
                <?php
                    echo $this->Form->control('uuid');
                    echo $this->Form->control('device_id', ['options' => $devices]);
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('agent_id', ['options' => $agents]);
                    echo $this->Form->control('calibration_date');
                    echo $this->Form->control('validity');
                    echo $this->Form->control('next_calibration_date', ['empty' => true]);
                    echo $this->Form->control('create_uid');
                    echo $this->Form->control('write_uid');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
