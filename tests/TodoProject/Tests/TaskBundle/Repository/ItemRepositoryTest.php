<?php

namespace Todo\Tests\TaskBundle\Repository;

use Silex\Application;
use Todo\TaskBundle\Repository\ItemRepository;

class ItemRepositoryTest extends \PHPUnit_Extensions_Database_TestCase {

    static private $pdo = null;

    private $conn;

    private $db;

    private $itemRepository;

    public function __construct() {
        $this->db = require __DIR__ . "/../../db.php";
        $this->itemRepository = new ItemRepository($this->db);
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

    public function testConstructItemRepositoryClass() {
        $this->itemRepository = new ItemRepository($this->db);
    }

    public function testFindAll() {
        $expected = $this->getConnection()->getRowCount('item');
        $actual = count($this->itemRepository->findAll());

        $this->assertEquals($expected, $actual);
    }

    public function testFind_inputId1_outputNameDownloadSilexSkeletonRest() {
        $inputId = 1;

        $expected = 'Download silex-skeleton-rest.';
        $item = $this->itemRepository->find($inputId);
        $actual = $item['name'];

        $this->assertEquals($expected, $actual);
    }

    public function testFind_inputId10_outputNull() {
        $inputId = 10;

        $expected = null;
        $actual = $this->itemRepository->find($inputId);

        $this->assertEquals($expected, $actual);
    }

    public function testDelete_inputId1() {
        $inputId = 1;

        $this->itemRepository->delete($inputId);
        $expected = null;
        $actual = $this->itemRepository->find($inputId);

        $this->assertEquals($expected, $actual);
    }

    public function testDelete_inputId10() {
        $inputId = 10;

        $expected = 0;
        $actual = $this->itemRepository->delete($inputId);

        $this->assertEquals($expected, $actual);
    }

    public function testUpdate_inputId2NameNewTask() {
        $inputId = 2;
        $inputParams = array('name' => 'New Task');

        $this->itemRepository->update($inputId, $inputParams);
        $itemRepository = $this->itemRepository->find($inputId);

        $expected = 'New Task';
        $actual = $itemRepository['name'];
        $this->assertEquals($expected, $actual);
    }

    public function testInsert_inputNameNewItem() {
        $inputParams = array('name' => 'New Item');
        $this->itemRepository->insert($inputParams);
        $lastInsertId = $this->db->lastInsertId();
        $itemRepository = $this->itemRepository->find($lastInsertId);

        $expected = 'New Item';
        $actual = $itemRepository['name'];

        $this->assertEquals($expected, $actual);
    }
}
