<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Company'), ['action' => 'edit', $company->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Company'), ['action' => 'delete', $company->id], ['confirm' => __('Are you sure you want to delete # {0}?', $company->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Companies'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Company'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="companies view content">
            <h3><?= h($company->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Uuid') ?></th>
                    <td><?= h($company->uuid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($company->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($company->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('City') ?></th>
                    <td><?= h($company->city) ?></td>
                </tr>
                <tr>
                    <th><?= __('Manager') ?></th>
                    <td><?= h($company->manager) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($company->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($company->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($company->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Create Uid') ?></th>
                    <td><?= $company->create_uid === null ? '' : $this->Number->format($company->create_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modifie Uid') ?></th>
                    <td><?= $company->modifie_uid === null ? '' : $this->Number->format($company->modifie_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($company->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($company->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Calibration Records') ?></h4>
                <?php if (!empty($company->calibration_records)) : ?>
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
                        <?php foreach ($company->calibration_records as $calibrationRecord) : ?>
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