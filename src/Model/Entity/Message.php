<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Message Entity
 *
 * @property int $id
 * @property string $receiver
 * @property string $content
 * @property \Cake\I18n\DateTime $created
 * @property int $create_uid
 * @property \Cake\I18n\DateTime $modified
 * @property int $write_uid
 * @property string $uuid
 * @property string $status
 * @property \Cake\I18n\DateTime $sent_date
 * @property int $calibration_record_id
 * @property int|null $team_id
 *
 * @property \App\Model\Entity\CalibrationRecord $calibration_record
 */
class Message extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'receiver' => true,
        'content' => true,
        'created' => true,
        'create_uid' => true,
        'modified' => true,
        'write_uid' => true,
        'uuid' => true,
        'status' => true,
        'sent_date' => true,
        'calibration_record_id' => true,
        'team_id' => true,
        'calibration_record' => true,
    ];
}
