<?php

namespace BadDeeds\Test;

use BadDeeds\Controller\Api;

class ApiTest extends \PHPUnit_Extensions_Database_TestCase
{
    private $db = null;
    private $api = null;

    /**
     * Get database connection.
     */
    protected function getConnection() : \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
    {
        if (null === $this->db) {
            $this->db = new \PDO(
                "mysql:host=" . DBHOST . ";dbname=" . DBNAME,
                DBUSER,
                DBPASS
            );
        }

        return $this->createDefaultDBConnection($this->db, ':memory:');
    }

    /**
     * Get initial dataset.
     */
    protected function getDataSet()
    {
        return $this->createMySQLXMLDataSet(__DIR__ . '/_files/seed.xml');
    }

    protected function assertListOfDeeds(array $list)
    {
        foreach ($list as $item)
        {
            $this->assertInstanceOf('\BadDeeds\Model\Deed', $item);
            $this->assertInternalType("int", $item->id);
            $this->assertInternalType("string", $item->subject);
            $this->assertInternalType("string", $item->description);
            foreach ($item as $key => $value) {
                $this->assertTrue(
                    in_array($key, ['id', 'subject', 'description'])
                );
            }
        }
    }

    /**
     * Setup environment.
     */
    public function setUp()
    {
        parent::setUp();
        $this->api = new Api($this->db);
    }

    /**
     * Test list deed with default parameters.
     */
    public function testListDefault()
    {
        $list = $this->api->list();
        $this->assertEquals(count($list), Api::DEFAULT_SIZE);
        $this->assertListOfDeeds($list);
    }

    /**
     * Test list deed with larger number of results per page.
     */
    public function testListLargerPageSize()
    {
        $pageSize = Api::DEFAULT_SIZE + 1;
        $list = $this->api->list(0, $pageSize);
        $this->assertEquals(count($list), $pageSize);
        $this->assertListOfDeeds($list);
    }

    /**
     * Test list deed with smaller number of results per page.
     */
    public function testListSmallerPageSize()
    {
        $pageSize = Api::DEFAULT_SIZE - 1;
        $list = $this->api->list(0, $pageSize);
        $this->assertEquals(count($list), $pageSize);
        $this->assertListOfDeeds($list);
    }

    /**
     * Test accessing the second page.
     */
    public function testListSecondPage()
    {
        $listSecondPage = $this->api->list(1);
        $listFirstPage  = $this->api->list(0);

        // Assert lists sizes.
        $this->assertEquals(count($listSecondPage), Api::DEFAULT_SIZE);
        $this->assertEquals(count($listFirstPage), Api::DEFAULT_SIZE);

        // Assert that the lists are completly distinct
        foreach ($listSecondPage as $sRow) {
            foreach ($listFirstPage as $fRow) {
                $this->assertNotEquals($sRow->id, $fRow->id);
            }
        }
    }
}
