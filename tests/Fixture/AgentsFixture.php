<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AgentsFixture
 */
class AgentsFixture extends TestFixture
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
                'uuid' => '2b480a33-b117-436b-a56f-a36c52e0edab',
                'registration_number' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'grade' => 'Lorem ipsum dolor sit amet',
                'phone' => 'Lorem ipsum dolor sit amet',
                'create_uid' => 1,
                'write_uid' => 1,
                'created' => '2025-11-28 05:43:46',
                'modified' => '2025-11-28 05:43:46',
            ],
        ];
        parent::init();
    }
}
