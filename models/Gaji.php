<?php

require_once __DIR__ . '/../classes/Model.php';

class Gaji extends Model {
    protected $table = 'gaji';

    public function getAll() {
        $sql = "SELECT g.*, k.nama as karyawan_nama, j.nama as jabatan_nama, j.gaji_pokok, j.tunjangan
                FROM {$this->table} g
                LEFT JOIN karyawan k ON g.id_karyawan = k.id
                LEFT JOIN jabatan j ON k.id_jabatan = j.id
                ORDER BY g.created_at DESC";
        return $this->fetchAll($sql);
    }

    public function getById($id) {
        $id = $this->escape($id);
        $sql = "SELECT g.*, k.nama as karyawan_nama, k.divisi, j.nama as jabatan_nama, j.gaji_pokok, j.tunjangan,
                r.rating, r.presentase_bonus, l.tarif as tarif_lembur
                FROM {$this->table} g
                LEFT JOIN karyawan k ON g.id_karyawan = k.id
                LEFT JOIN jabatan j ON k.id_jabatan = j.id
                LEFT JOIN rating r ON k.id_rating = r.id
                LEFT JOIN lembur l ON g.id_lembur = l.id
                WHERE g.id = '$id'";
        return $this->fetch($sql);
    }

    public function getByKaryawanId($id_karyawan) {
        $id_karyawan = $this->escape($id_karyawan);
        $sql = "SELECT g.*, k.nama as karyawan_nama, j.nama as jabatan_nama, j.gaji_pokok, j.tunjangan
                FROM {$this->table} g
                LEFT JOIN karyawan k ON g.id_karyawan = k.id
                LEFT JOIN jabatan j ON k.id_jabatan = j.id
                WHERE g.id_karyawan = '$id_karyawan'
                ORDER BY g.periode DESC";
        return $this->fetchAll($sql);
    }

    public function add($id_karyawan, $id_lembur, $periode, $lama_lembur, $total_lembur, $total_bonus, $total_tunjangan, $total_pendapatan) {
        $id_karyawan = $this->escape($id_karyawan);
        $id_lembur = $this->escape($id_lembur);
        $periode = $this->escape($periode);
        $lama_lembur = $this->escape($lama_lembur);
        $total_lembur = $this->escape($total_lembur);
        $total_bonus = $this->escape($total_bonus);
        $total_tunjangan = $this->escape($total_tunjangan);
        $total_pendapatan = $this->escape($total_pendapatan);

        $sql = "INSERT INTO {$this->table} (id_karyawan, id_lembur, periode, lama_lembur, total_lembur, total_bonus, total_tunjangan, total_pendapatan)
                VALUES ('$id_karyawan', '$id_lembur', '$periode', '$lama_lembur', '$total_lembur', '$total_bonus', '$total_tunjangan', '$total_pendapatan')";

        $this->execute($sql);
        return $this->getLastId();
    }

    public function update($id, $lama_lembur, $total_lembur, $total_bonus, $total_tunjangan, $total_pendapatan) {
        $id = $this->escape($id);
        $lama_lembur = $this->escape($lama_lembur);
        $total_lembur = $this->escape($total_lembur);
        $total_bonus = $this->escape($total_bonus);
        $total_tunjangan = $this->escape($total_tunjangan);
        $total_pendapatan = $this->escape($total_pendapatan);

        $sql = "UPDATE {$this->table} SET lama_lembur = '$lama_lembur', total_lembur = '$total_lembur',
                total_bonus = '$total_bonus', total_tunjangan = '$total_tunjangan',
                total_pendapatan = '$total_pendapatan' WHERE id = '$id'";

        $this->execute($sql);
        return $this->getAffectedRows();
    }

    public function delete($id) {
        $id = $this->escape($id);
        $sql = "DELETE FROM {$this->table} WHERE id = '$id'";
        return $this->execute($sql);
    }
}
