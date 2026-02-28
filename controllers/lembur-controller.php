<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Lembur.php';

$lembur_model = new Lembur();

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $tarif = $_POST['tarif'] ?? 0;

    if (empty($tarif) || $tarif <= 0) {
        $_SESSION['error'] = 'Tarif harus lebih dari 0';
        header('Location: ' . BASE_URL . 'views/lembur-form.php');
        exit;
    }

    $lembur_model->add($tarif);
    $_SESSION['success'] = 'Tarif lembur berhasil ditambahkan!';
    header('Location: ' . BASE_URL . 'views/lembur.php');
    exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $tarif = $_POST['tarif'] ?? 0;

    if (empty($id) || empty($tarif) || $tarif <= 0) {
        $_SESSION['error'] = 'Data tidak valid';
        header('Location: ' . BASE_URL . 'views/lembur.php');
        exit;
    }

    $lembur_model->update($id, $tarif);
    $_SESSION['success'] = 'Tarif lembur berhasil diperbarui!';
    header('Location: ' . BASE_URL . 'views/lembur-detail.php?id=' . $id);
    exit;
}

if ($action === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $lembur_model->delete($id);
    $_SESSION['success'] = 'Tarif lembur berhasil dihapus!';
    header('Location: ' . BASE_URL . 'views/lembur.php');
    exit;
}

header('Location: ' . BASE_URL . 'views/lembur.php');
?>
