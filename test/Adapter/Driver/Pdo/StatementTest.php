<?php

/**
 * @see       https://github.com/laminas/laminas-db for the canonical source repository
 * @copyright https://github.com/laminas/laminas-db/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-db/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Db\Adapter\Driver\Pdo;

use Laminas\Db\Adapter\Driver\Pdo\Connection;
use Laminas\Db\Adapter\Driver\Pdo\Pdo;
use Laminas\Db\Adapter\Driver\Pdo\Statement;
use Laminas\Db\Adapter\ParameterContainer;

class StatementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Statement
     */
    protected $statement;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->statement = new Statement;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Laminas\Db\Adapter\Driver\Pdo\Statement::setDriver
     */
    public function testSetDriver()
    {
        $this->assertEquals($this->statement, $this->statement->setDriver(new Pdo(array())));
    }

    /**
     * @covers Laminas\Db\Adapter\Driver\Pdo\Statement::setParameterContainer
     */
    public function testSetParameterContainer()
    {
        $this->assertSame($this->statement, $this->statement->setParameterContainer(new ParameterContainer));
    }

    /**
     * @covers Laminas\Db\Adapter\Driver\Pdo\Statement::getParameterContainer
     * @todo   Implement testGetParameterContainer().
     */
    public function testGetParameterContainer()
    {
        $container = new ParameterContainer;
        $this->statement->setParameterContainer($container);
        $this->assertSame($container, $this->statement->getParameterContainer());
    }

    /**
     * @covers Laminas\Db\Adapter\Driver\Pdo\Statement::getResource
     */
    public function testGetResource()
    {
        $pdo = new TestAsset\SqliteMemoryPdo();
        $stmt = $pdo->prepare('SELECT 1');
        $this->statement->setResource($stmt);

        $this->assertSame($stmt, $this->statement->getResource());
    }

    /**
     * @covers Laminas\Db\Adapter\Driver\Pdo\Statement::setSql
     */
    public function testSetSql()
    {
        $this->statement->setSql('SELECT 1');
        $this->assertEquals('SELECT 1', $this->statement->getSql());
    }

    /**
     * @covers Laminas\Db\Adapter\Driver\Pdo\Statement::getSql
     */
    public function testGetSql()
    {
        $this->statement->setSql('SELECT 1');
        $this->assertEquals('SELECT 1', $this->statement->getSql());
    }

    /**
     * @covers Laminas\Db\Adapter\Driver\Pdo\Statement::prepare
     * @todo   Implement testPrepare().
     */
    public function testPrepare()
    {
        $this->statement->initialize(new TestAsset\SqliteMemoryPdo());
        $this->assertNull($this->statement->prepare('SELECT 1'));
    }

    /**
     * @covers Laminas\Db\Adapter\Driver\Pdo\Statement::isPrepared
     */
    public function testIsPrepared()
    {
        $this->assertFalse($this->statement->isPrepared());
        $this->statement->initialize(new TestAsset\SqliteMemoryPdo());
        $this->statement->prepare('SELECT 1');
        $this->assertTrue($this->statement->isPrepared());
    }

    /**
     * @covers Laminas\Db\Adapter\Driver\Pdo\Statement::execute
     */
    public function testExecute()
    {
        $this->statement->setDriver(new Pdo(new Connection($pdo = new TestAsset\SqliteMemoryPdo())));
        $this->statement->initialize($pdo);
        $this->statement->prepare('SELECT 1');
        $this->assertInstanceOf('Laminas\Db\Adapter\Driver\Pdo\Result', $this->statement->execute());
    }
}
