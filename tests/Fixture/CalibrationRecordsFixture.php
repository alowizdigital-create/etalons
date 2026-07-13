<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CalibrationRecordsFixture
 */
class CalibrationRecordsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'uuid' => '5303a271-8a58-4ab1-b912-135ac3367659',
                'device_id' => 1,
                'company_id' => 1,
                'agent_id' => 1,
                'calibration_date' => '2025-11-28',
                'validity' => 'Lorem ipsum dolor sit amet',
                'next_calibration_date' => '2025-11-28',
                'create_uid' => 1,
                'write_uid' => 1,
                'created' => '2025-11-28 13:32:14',
                'modified' => '2025-11-28 13:32:14',
            ],
        ];
        parent::init();
    }
}
