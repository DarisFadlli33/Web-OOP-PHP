<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Jabatan.php';

$jabatan_model = new Jabatan();

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $gaji_pokok = $_POST['gaji_pokok'] ?? 0;
    $tunjangan = $_POST['tunjangan'] ?? 0;

    if (empty($nama)) {
        $_SESSION['error'] = 'Nama jabatan harus diisi';
        header('Location: ' . BASE_URL . 'views/jabatan-form.php');
        exit;
    }

    $jabatan_model->add($nama, $gaji_pokok, $tunjangan);
    $_SESSION['success'] = 'Jabatan berhasil ditambahkan!';
    header('Location: ' . BASE_URL . 'views/jabatan.php');
    exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $gaji_pokok = $_POST['gaji_pokok'] ?? 0;
    $tunjangan = $_POST['tunjangan'] ?? 0;

    if (empty($id) || empty($nama)) {
        $_SESSION['error'] = 'Data tidak lengkap';
        header('Location: ' . BASE_URL . 'views/jabatan.php');
        exit;
    }

    $jabatan_model->update($id, $nama, $gaji_pokok, $tunjangan);
    $_SESSION['success'] = 'Jabatan berhasil diperbarui!';
    header('Location: ' . BASE_URL . 'views/jabatan-detail.php?id=' . $id);
    exit;
}

if ($action === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $jabatan_model->delete($id);
    $_SESSION['success'] = 'Jabatan berhasil dihapus!';
    header('Location: ' . BASE_URL . 'views/jabatan.php');
    exit;
}

header('Location: ' . BASE_URL . 'views/jabatan.php');
?>
