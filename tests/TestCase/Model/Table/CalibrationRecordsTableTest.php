<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CalibrationRecordsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CalibrationRecordsTable Test Case
 */
class CalibrationRecordsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CalibrationRecordsTable
     */
    protected $CalibrationRecords;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.CalibrationRecords',
        'app.Devices',
        'app.Companies',
        'app.Agents',
        'app.Messages',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CalibrationRecords') ? [] : ['className' => CalibrationRecordsTable::class];
        $this->CalibrationRecords = $this->getTableLocator()->get('CalibrationRecords', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CalibrationRecords);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\CalibrationRecordsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\CalibrationRecordsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
