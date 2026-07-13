<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MessagesFixture
 */
class MessagesFixture extends TestFixture
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
                'receiver' => 'Lorem ipsum dolor ',
                'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2025-12-02 07:51:18',
                'create_uid' => 1,
                'modified' => '2025-12-02 07:51:18',
                'write_uid' => 1,
                'uuid' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ip',
                'sent_date' => '2025-12-02 07:51:18',
                'calibration_record_id' => 1,
                'team_id' => 1,
            ],
        ];
        parent::init();
    }
}
