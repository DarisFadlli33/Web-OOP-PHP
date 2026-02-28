<?php

class Model {
    protected $db;
    protected $table;

    public function __construct() {
        require_once __DIR__ . '/../config/Database.php';
        $this->db = new Database();
    }

    public function query($sql) {
        return $this->db->query($sql);
    }

    public function fetch($sql) {
        $result = $this->query($sql);
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return null;
    }

    public function fetchAll($sql) {
        $result = $this->query($sql);
        $data = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function execute($sql) {
        return $this->query($sql);
    }

    public function getLastId() {
        return $this->db->lastInsertId();
    }

    public function getAffectedRows() {
        return $this->db->affectedRows();
    }

    public function escape($str) {
        return $this->db->escape($str);
    }
}
