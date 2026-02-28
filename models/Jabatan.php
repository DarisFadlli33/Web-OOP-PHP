<?php

require_once __DIR__ . '/../classes/Model.php';

class Jabatan extends Model {
    protected $table = 'jabatan';

    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        return $this->fetchAll($sql);
    }

    public function getById($id) {
        $id = $this->escape($id);
        $sql = "SELECT * FROM {$this->table} WHERE id = '$id'";
        return $this->fetch($sql);
    }

    public function add($nama, $gaji_pokok, $tunjangan) {
        $nama = $this->escape($nama);
        $gaji_pokok = $this->escape($gaji_pokok);
        $tunjangan = $this->escape($tunjangan);

        $sql = "INSERT INTO {$this->table} (nama, gaji_pokok, tunjangan)
                VALUES ('$nama', '$gaji_pokok', '$tunjangan')";

        $this->execute($sql);
        return $this->getLastId();
    }

    public function update($id, $nama, $gaji_pokok, $tunjangan) {
        $id = $this->escape($id);
        $nama = $this->escape($nama);
        $gaji_pokok = $this->escape($gaji_pokok);
        $tunjangan = $this->escape($tunjangan);

        $sql = "UPDATE {$this->table} SET nama = '$nama', gaji_pokok = '$gaji_pokok',
                tunjangan = '$tunjangan' WHERE id = '$id'";

        $this->execute($sql);
        return $this->getAffectedRows();
    }

    public function delete($id) {
        $id = $this->escape($id);
        $sql = "DELETE FROM {$this->table} WHERE id = '$id'";
        return $this->execute($sql);
    }
}
