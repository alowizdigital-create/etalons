<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Device Entity
 *
 * @property int $id
 * @property string $uuid
 * @property string $device_code
 * @property string $name
 * @property string|null $manufacturer
 * @property \Cake\I18n\Date|null $acquisition_date
 * @property int|null $create_uid
 * @property int|null $modifie_uid
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\CalibrationRecord[] $calibration_records
 */
class Device extends Entity
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
        'device_code' => true,
        'name' => true,
        'manufacturer' => true,
        'acquisition_date' => true,
        'create_uid' => true,
        'modifie_uid' => true,
        'created' => true,
        'modified' => true,
        'calibration_records' => true,
    ];
}
