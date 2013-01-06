<?php

namespace Todo\Tests\TaskBundle\Core;

use Silex\Application;
use Todo\TaskBundle\Core\RepositoryCore;

class RepositoryCoreTest extends \PHPUnit_Extensions_Database_TestCase {

    static private $pdo = null;

    private $conn;

    private $db;

    private $repositoryCore;

    public function __construct() {
        $tableName = 'item';

        $this->db = require __DIR__ . "/../../db.php";
        $this->repositoryCore = new RepositoryCore($this->db);
        $this->repositoryCore->setTable($tableName);
    }

    public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new \PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
        }

        return $this->conn;
    }

    public function getDataSet()
    {
        self::$pdo->exec("set foreign_key_checks=0");

        return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            __DIR__ . "/../../DataSet/Item/seedItem.yml"
        );
    }

    public function testConstructRepositoryCoreClass() {
        $inputTableName = 'item';
        $this->repositoryCore = new RepositoryCore($this->db);
        $this->repositoryCore->setTable($inputTableName);
    }

    public function testFindAll() {
        $expected = $this->getConnection()->getRowCount('item');
        $actual = count($this->repositoryCore->findAll());

        $this->assertEquals($expected, $actual);
    }

    public function testFind_inputId1_outputNameDownloadSilexSkeletonRest() {
        $inputId = 1;

        $expected = 'Download silex-skeleton-rest.';
        $item = $this->repositoryCore->find($inputId);
        $actual = $item['name'];

        $this->assertEquals($expected, $actual);
    }

    public function testFind_inputId2_outputNameUtilizeTheSkeletonSoICanUseItForMyProject() {
        $inputId = 2;

        $expected = 'Utilize the skeleton so I can use it for my project.';
        $item = $this->repositoryCore->find($inputId);
        $actual = $item['name'];

        $this->assertEquals($expected, $actual);
    }

    public function testFind_inputId10_outputNull() {
        $inputId = 10;

        $expected = null;
        $actual = $this->repositoryCore->find($inputId);

        $this->assertEquals($expected, $actual);
    }

    public function testDelete_inputId1() {
        $inputId = 1;

        $this->repositoryCore->delete($inputId);
        $expected = null;
        $actual = $this->repositoryCore->find($inputId);

        $this->assertEquals($expected, $actual);
    }

    public function testDelete_inputId10() {
        $inputId = 10;

        $expected = 0;
        $actual = $this->repositoryCore->delete($inputId);

        $this->assertEquals($expected, $actual);
    }

    public function testUpdate_inputId2NameFooBar() {
        $inputId = 2;
        $inputParams = array('name' => 'Foo Bar');

        $this->repositoryCore->update($inputId, $inputParams);
        $repositoryCore = $this->repositoryCore->find($inputId);

        $expected = 'Foo Bar';
        $actual = $repositoryCore['name'];
        $this->assertEquals($expected, $actual);
    }

    public function testInsert_inputNameFooBar() {
        $inputParams = array('name' => 'Foo Bar');
        $this->repositoryCore->insert($inputParams);
        $lastInsertId = $this->db->lastInsertId();
        $repositoryCore = $this->repositoryCore->find($lastInsertId);

        $expected = 'Foo Bar';
        $actual = $repositoryCore['name'];

        $this->assertEquals($expected, $actual);
    }
}
