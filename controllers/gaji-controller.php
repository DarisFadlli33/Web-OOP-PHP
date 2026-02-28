<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Gaji.php';
require_once __DIR__ . '/../models/Karyawan.php';

$gaji_model = new Gaji();
$karyawan_model = new Karyawan();

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_karyawan = $_POST['id_karyawan'] ?? '';
    $id_lembur = $_POST['id_lembur'] ?? '';
    $periode = $_POST['periode'] ?? date('Y');
    $lama_lembur = $_POST['lama_lembur'] ?? 0;
    $total_lembur = $_POST['total_lembur'] ?? 0;
    $total_bonus = $_POST['total_bonus'] ?? 0;
    $total_tunjangan = $_POST['total_tunjangan'] ?? 0;
    $total_pendapatan = $_POST['total_pendapatan'] ?? 0;

    if (empty($id_karyawan) || empty($id_lembur)) {
        $_SESSION['error'] = 'Data tidak lengkap. Pilih karyawan dan tarif lembur terlebih dahulu.';
        header('Location: ' . BASE_URL . 'views/gaji-form.php');
        exit;
    }

    $gaji_model->add($id_karyawan, $id_lembur, $periode, $lama_lembur, $total_lembur, $total_bonus, $total_tunjangan, $total_pendapatan);
    $_SESSION['success'] = 'Gaji karyawan berhasil dihitung dan disimpan!';
    header('Location: ' . BASE_URL . 'views/gaji.php');
    exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $lama_lembur = $_POST['lama_lembur'] ?? 0;
    $total_lembur = $_POST['total_lembur'] ?? 0;
    $total_bonus = $_POST['total_bonus'] ?? 0;
    $total_tunjangan = $_POST['total_tunjangan'] ?? 0;
    $total_pendapatan = $_POST['total_pendapatan'] ?? 0;

    if (empty($id)) {
        $_SESSION['error'] = 'Data tidak valid';
        header('Location: ' . BASE_URL . 'views/gaji.php');
        exit;
    }

    $gaji_model->update($id, $lama_lembur, $total_lembur, $total_bonus, $total_tunjangan, $total_pendapatan);
    $_SESSION['success'] = 'Data gaji berhasil diperbarui!';
    header('Location: ' . BASE_URL . 'views/gaji-detail.php?id=' . $id);
    exit;
}

if ($action === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $gaji_model->delete($id);
    $_SESSION['success'] = 'Data gaji berhasil dihapus!';
    header('Location: ' . BASE_URL . 'views/gaji.php');
    exit;
}

header('Location: ' . BASE_URL . 'views/gaji.php');
?>
