<?php

require_once __DIR__ . '/../classes/Model.php';

class Lembur extends Model {
    protected $table = 'lembur';

    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        return $this->fetchAll($sql);
    }

    public function getById($id) {
        $id = $this->escape($id);
        $sql = "SELECT * FROM {$this->table} WHERE id = '$id'";
        return $this->fetch($sql);
    }

    public function add($tarif) {
        $tarif = $this->escape($tarif);

        $sql = "INSERT INTO {$this->table} (tarif)
                VALUES ('$tarif')";

        $this->execute($sql);
        return $this->getLastId();
    }

    public function update($id, $tarif) {
        $id = $this->escape($id);
        $tarif = $this->escape($tarif);

        $sql = "UPDATE {$this->table} SET tarif = '$tarif' WHERE id = '$id'";

        $this->execute($sql);
        return $this->getAffectedRows();
    }

    public function delete($id) {
        $id = $this->escape($id);
        $sql = "DELETE FROM {$this->table} WHERE id = '$id'";
        return $this->execute($sql);
    }

    public function getTarif() {
        $sql = "SELECT tarif FROM {$this->table} LIMIT 1";
        $result = $this->fetch($sql);
        return $result ? $result['tarif'] : 0;
    }
}
