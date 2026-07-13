<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Device $device
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Device'), ['action' => 'edit', $device->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Device'), ['action' => 'delete', $device->id], ['confirm' => __('Are you sure you want to delete # {0}?', $device->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Devices'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Device'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="devices view content">
            <h3><?= h($device->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Uuid') ?></th>
                    <td><?= h($device->uuid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Device Code') ?></th>
                    <td><?= h($device->device_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($device->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Manufacturer') ?></th>
                    <td><?= h($device->manufacturer) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($device->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Create Uid') ?></th>
                    <td><?= $device->create_uid === null ? '' : $this->Number->format($device->create_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modifie Uid') ?></th>
                    <td><?= $device->modifie_uid === null ? '' : $this->Number->format($device->modifie_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Acquisition Date') ?></th>
                    <td><?= h($device->acquisition_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($device->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($device->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Calibration Records') ?></h4>
                <?php if (!empty($device->calibration_records)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Uuid') ?></th>
                            <th><?= __('Device Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Agent Id') ?></th>
                            <th><?= __('Calibration Date') ?></th>
                            <th><?= __('Validity') ?></th>
                            <th><?= __('Next Calibration Date') ?></th>
                            <th><?= __('Create Uid') ?></th>
                            <th><?= __('Write Uid') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($device->calibration_records as $calibrationRecord) : ?>
                        <tr>
                            <td><?= h($calibrationRecord->id) ?></td>
                            <td><?= h($calibrationRecord->uuid) ?></td>
                            <td><?= h($calibrationRecord->device_id) ?></td>
                            <td><?= h($calibrationRecord->company_id) ?></td>
                            <td><?= h($calibrationRecord->agent_id) ?></td>
                            <td><?= h($calibrationRecord->calibration_date) ?></td>
                            <td><?= h($calibrationRecord->validity) ?></td>
                            <td><?= h($calibrationRecord->next_calibration_date) ?></td>
                            <td><?= h($calibrationRecord->create_uid) ?></td>
                            <td><?= h($calibrationRecord->write_uid) ?></td>
                            <td><?= h($calibrationRecord->created) ?></td>
                            <td><?= h($calibrationRecord->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CalibrationRecords', 'action' => 'view', $calibrationRecord->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CalibrationRecords', 'action' => 'edit', $calibrationRecord->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'CalibrationRecords', 'action' => 'delete', $calibrationRecord->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $calibrationRecord->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>