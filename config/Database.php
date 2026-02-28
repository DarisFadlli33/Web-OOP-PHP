<?php

class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "kantor";
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->db);

        if (!$this->conn) {
            die("Error: Koneksi database gagal - " . mysqli_connect_error());
        }

        mysqli_set_charset($this->conn, "utf8mb4");
    }

    public function getConnection() {
        return $this->conn;
    }

    public function query($sql) {
        return mysqli_query($this->conn, $sql);
    }

    public function escape($str) {
        return mysqli_real_escape_string($this->conn, $str);
    }

    public function lastInsertId() {
        return mysqli_insert_id($this->conn);
    }

    public function affectedRows() {
        return mysqli_affected_rows($this->conn);
    }

    public function __destruct() {
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }
}
