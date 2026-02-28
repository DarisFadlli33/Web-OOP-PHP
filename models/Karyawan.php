<?php

require_once __DIR__ . '/../classes/Model.php';

class Karyawan extends Model {
    protected $table = 'karyawan';

    public function getAll() {
        $sql = "SELECT k.*, j.nama as jabatan_nama, j.gaji_pokok, j.tunjangan, r.rating, r.presentase_bonus
                FROM {$this->table} k
                LEFT JOIN jabatan j ON k.id_jabatan = j.id
                LEFT JOIN rating r ON k.id_rating = r.id
                ORDER BY k.created_at DESC";
        return $this->fetchAll($sql);
    }

    public function getById($id) {
        $id = $this->escape($id);
        $sql = "SELECT k.*, j.nama as jabatan_nama, j.gaji_pokok, j.tunjangan, r.rating, r.presentase_bonus
                FROM {$this->table} k
                LEFT JOIN jabatan j ON k.id_jabatan = j.id
                LEFT JOIN rating r ON k.id_rating = r.id
                WHERE k.id = '$id'";
        return $this->fetch($sql);
    }

    public function getRecent($limit = 5) {
        $limit = (int)$limit;
        $sql = "SELECT k.*, j.nama as jabatan_nama, r.rating
                FROM {$this->table} k
                LEFT JOIN jabatan j ON k.id_jabatan = j.id
                LEFT JOIN rating r ON k.id_rating = r.id
                ORDER BY k.created_at DESC
                LIMIT $limit";
        return $this->fetchAll($sql);
    }

    public function add($nama, $divisi, $id_jabatan, $id_rating, $alamat = '', $umur = '', $jenis_kelamin = '', $status = '', $aktif = 1, $path_image = null) {
        $nama = $this->escape($nama);
        $divisi = $this->escape($divisi);
        $id_jabatan = $this->escape($id_jabatan);
        $id_rating = $this->escape($id_rating);
        $alamat = $this->escape($alamat);
        $umur = $this->escape($umur);
        $jenis_kelamin = $this->escape($jenis_kelamin);
        $status = $this->escape($status);
        $aktif = (int)$aktif;
        $path_image = $path_image ? "'" . $this->escape($path_image) . "'" : 'NULL';

        $sql = "INSERT INTO {$this->table} (nama, divisi, id_jabatan, id_rating, alamat, umur, jenis_kelamin, status, aktif, path_image)
                VALUES ('$nama', '$divisi', '$id_jabatan', '$id_rating', '$alamat', '$umur', '$jenis_kelamin', '$status', $aktif, $path_image)";

        $this->execute($sql);
        return $this->getLastId();
    }

    public function update($id, $nama, $divisi, $id_jabatan, $id_rating, $alamat = '', $umur = '', $jenis_kelamin = '', $status = '', $aktif = 1, $path_image = null) {
        $id = $this->escape($id);
        $nama = $this->escape($nama);
        $divisi = $this->escape($divisi);
        $id_jabatan = $this->escape($id_jabatan);
        $id_rating = $this->escape($id_rating);
        $alamat = $this->escape($alamat);
        $umur = $this->escape($umur);
        $jenis_kelamin = $this->escape($jenis_kelamin);
        $status = $this->escape($status);
        $aktif = (int)$aktif;

        $path_image_clause = $path_image ? ", path_image = '" . $this->escape($path_image) . "'" : '';

        $sql = "UPDATE {$this->table} SET nama = '$nama', divisi = '$divisi', id_jabatan = '$id_jabatan',
                id_rating = '$id_rating', alamat = '$alamat', umur = '$umur', jenis_kelamin = '$jenis_kelamin',
                status = '$status', aktif = $aktif{$path_image_clause} WHERE id = '$id'";

        $this->execute($sql);
        return $this->getAffectedRows();
    }

    public function delete($id) {
        $id = $this->escape($id);
        $sql = "DELETE FROM {$this->table} WHERE id = '$id'";
        return $this->execute($sql);
    }

    public function getTotalKaryawan() {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->fetch($sql);
        return $result ? $result['total'] : 0;
    }
}
