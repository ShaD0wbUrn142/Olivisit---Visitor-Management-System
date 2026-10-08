<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrganisationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrganisationsTable Test Case
 */
class OrganisationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrganisationsTable
     */
    protected $Organisations;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Organisations',
        'app.Houserules',
        'app.Staff',
        'app.Visitors',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Organisations') ? [] : ['className' => OrganisationsTable::class];
        $this->Organisations = $this->getTableLocator()->get('Organisations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Organisations);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OrganisationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\OrganisationsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
