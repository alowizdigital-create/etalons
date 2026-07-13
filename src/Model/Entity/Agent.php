<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Agent Entity
 *
 * @property int $id
 * @property string $uuid
 * @property string $registration_number
 * @property string $name
 * @property string|null $grade
 * @property string|null $phone
 * @property int|null $create_uid
 * @property int|null $write_uid
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\CalibrationRecord[] $calibration_records
 */
class Agent extends Entity
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
        'registration_number' => true,
        'name' => true,
        'grade' => true,
        'phone' => true,
        'create_uid' => true,
        'write_uid' => true,
        'created' => true,
        'modified' => true,
        'calibration_records' => true,
    ];
}
