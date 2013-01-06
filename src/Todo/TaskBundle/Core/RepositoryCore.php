<?php

namespace Todo\TaskBundle\Core;

class RepositoryCore {
    protected $db;

    protected $table;

    public function setDB($db) {
        $this->db = $db;
    }

    public function setTable($table) {
        $this->table = $table;
    }

    public function __construct($db) {
        $this->setDB($db);

        $calledClass = explode('\\', get_called_class());
        $class = end($calledClass);

        $table = strtolower(substr($class, 0, -10));
        $this->setTable($table);
    }

    public function findAll() {
        $sql = "SELECT * FROM `$this->table`";
        $categories = $this->db->fetchAll($sql);

        return $categories;
    }

    public function find($id) {
        $sql = "SELECT * FROM `$this->table` WHERE `id` = $id";
        $category = $this->db->fetchAssoc($sql);

        return $category;
    }

    public function delete($id) {
        return $this->db->delete($this->table, array('id' => $id));
    }

    public function insert($params) {
        return $this->db->insert($this->table, $params);
    }

    public function update($id, $params) {
        return $this->db->update($this->table, $params, array('id' => $id));
    }
}
