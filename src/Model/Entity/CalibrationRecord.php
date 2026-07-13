<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CalibrationRecord Entity
 *
 * @property int $id
 * @property string $uuid
 * @property int $device_id
 * @property int $company_id
 * @property int $agent_id
 * @property \Cake\I18n\Date $calibration_date
 * @property string|null $validity
 * @property \Cake\I18n\Date|null $next_calibration_date
 * @property int|null $create_uid
 * @property int|null $write_uid
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Device $device
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Agent $agent
 * @property \App\Model\Entity\Message[] $messages
 */
class CalibrationRecord extends Entity
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
        'uuid' => true,
        'device_id' => true,
        'company_id' => true,
        'agent_id' => true,
        'calibration_date' => true,
        'validity' => true,
        'next_calibration_date' => true,
        'create_uid' => true,
        'write_uid' => true,
        'created' => true,
        'modified' => true,
        'device' => true,
        'company' => true,
        'agent' => true,
        'messages' => true,
    ];
}
