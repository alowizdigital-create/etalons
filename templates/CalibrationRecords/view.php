<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CalibrationRecord $calibrationRecord
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Calibration Record'), ['action' => 'edit', $calibrationRecord->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Calibration Record'), ['action' => 'delete', $calibrationRecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $calibrationRecord->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Calibration Records'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Calibration Record'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="calibrationRecords view content">
            <h3><?= h($calibrationRecord->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Uuid') ?></th>
                    <td><?= h($calibrationRecord->uuid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Device') ?></th>
                    <td><?= $calibrationRecord->hasValue('device') ? $this->Html->link($calibrationRecord->device->name, ['controller' => 'Devices', 'action' => 'view', $calibrationRecord->device->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $calibrationRecord->hasValue('company') ? $this->Html->link($calibrationRecord->company->name, ['controller' => 'Companies', 'action' => 'view', $calibrationRecord->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Agent') ?></th>
                    <td><?= $calibrationRecord->hasValue('agent') ? $this->Html->link($calibrationRecord->agent->name, ['controller' => 'Agents', 'action' => 'view', $calibrationRecord->agent->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Validity') ?></th>
                    <td><?= h($calibrationRecord->validity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($calibrationRecord->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Create Uid') ?></th>
                    <td><?= $calibrationRecord->create_uid === null ? '' : $this->Number->format($calibrationRecord->create_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Write Uid') ?></th>
                    <td><?= $calibrationRecord->write_uid === null ? '' : $this->Number->format($calibrationRecord->write_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Calibration Date') ?></th>
                    <td><?= h($calibrationRecord->calibration_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Next Calibration Date') ?></th>
                    <td><?= h($calibrationRecord->next_calibration_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($calibrationRecord->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($calibrationRecord->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Messages') ?></h4>
                <?php if (!empty($calibrationRecord->messages)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Receiver') ?></th>
                            <th><?= __('Content') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Create Uid') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Write Uid') ?></th>
                            <th><?= __('Uuid') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Sent Date') ?></th>
                            <th><?= __('Calibration Record Id') ?></th>
                            <th><?= __('Team Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($calibrationRecord->messages as $message) : ?>
                        <tr>
                            <td><?= h($message->id) ?></td>
                            <td><?= h($message->receiver) ?></td>
                            <td><?= h($message->content) ?></td>
                            <td><?= h($message->created) ?></td>
                            <td><?= h($message->create_uid) ?></td>
                            <td><?= h($message->modified) ?></td>
                            <td><?= h($message->write_uid) ?></td>
                            <td><?= h($message->uuid) ?></td>
                            <td><?= h($message->status) ?></td>
                            <td><?= h($message->sent_date) ?></td>
                            <td><?= h($message->calibration_record_id) ?></td>
                            <td><?= h($message->team_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Messages', 'action' => 'view', $message->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Messages', 'action' => 'edit', $message->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Messages', 'action' => 'delete', $message->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $message->id),
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