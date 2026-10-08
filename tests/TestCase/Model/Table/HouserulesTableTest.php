<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HouserulesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HouserulesTable Test Case
 */
class HouserulesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\HouserulesTable
     */
    protected $Houserules;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Houserules',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Houserules') ? [] : ['className' => HouserulesTable::class];
        $this->Houserules = $this->getTableLocator()->get('Houserules', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Houserules);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\HouserulesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
