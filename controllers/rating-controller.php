<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Rating.php';

$rating_model = new Rating();

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'] ?? '';
    $presentase_bonus = $_POST['presentase_bonus'] ?? 0;

    if (empty($rating)) {
        $_SESSION['error'] = 'Rating harus diisi';
        header('Location: ' . BASE_URL . 'views/rating-form.php');
        exit;
    }

    $rating_model->add($rating, $presentase_bonus);
    $_SESSION['success'] = 'Rating berhasil ditambahkan!';
    header('Location: ' . BASE_URL . 'views/rating.php');
    exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $rating = $_POST['rating'] ?? '';
    $presentase_bonus = $_POST['presentase_bonus'] ?? 0;

    if (empty($id) || empty($rating)) {
        $_SESSION['error'] = 'Data tidak lengkap';
        header('Location: ' . BASE_URL . 'views/rating.php');
        exit;
    }

    $rating_model->update($id, $rating, $presentase_bonus);
    $_SESSION['success'] = 'Rating berhasil diperbarui!';
    header('Location: ' . BASE_URL . 'views/rating-detail.php?id=' . $id);
    exit;
}

if ($action === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $rating_model->delete($id);
    $_SESSION['success'] = 'Rating berhasil dihapus!';
    header('Location: ' . BASE_URL . 'views/rating.php');
    exit;
}

header('Location: ' . BASE_URL . 'views/rating.php');
?>
