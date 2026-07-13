<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DevicesFixture
 */
class DevicesFixture extends TestFixture
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
                'uuid' => '6f9e5466-5030-45be-b94d-351a1b06bf06',
                'device_code' => 'Lorem ipsum dolor ',
                'name' => 'Lorem ipsum dolor sit amet',
                'manufacturer' => 'Lorem ipsum dolor sit amet',
                'acquisition_date' => '2025-11-28',
                'create_uid' => 1,
                'modifie_uid' => 1,
                'created' => '2025-11-28 06:50:58',
                'modified' => '2025-11-28 06:50:58',
            ],
        ];
        parent::init();
    }
}
