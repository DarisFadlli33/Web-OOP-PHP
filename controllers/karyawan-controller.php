<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Karyawan.php';
require_once __DIR__ . '/../classes/FileUploadHandler.php';

$karyawan_model = new Karyawan();
$upload_dir = __DIR__ . '/../assets/images/employees';
$file_handler = new FileUploadHandler($upload_dir);

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $divisi = $_POST['divisi'] ?? '';
    $id_jabatan = $_POST['id_jabatan'] ?? '';
    $id_rating = $_POST['id_rating'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $umur = $_POST['umur'] ?? '';
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $status = $_POST['status'] ?? '';
    $aktif = isset($_POST['aktif']) ? 1 : 0;

    if (empty($nama) || empty($divisi) || empty($id_jabatan) || empty($id_rating)) {
        $_SESSION['error'] = 'Data tidak lengkap. Nama, Divisi, Jabatan, dan Rating harus diisi.';
        header('Location: ' . BASE_URL . 'views/karyawan-form.php');
        exit;
    }

    $image_path = null;

    // Handle file upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
        $upload_result = $file_handler->upload('photo');
        if ($upload_result['success']) {
            $image_path = 'assets/images/employees/' . $upload_result['filename'];
        } else {
            $_SESSION['error'] = 'Upload gambar gagal: ' . $upload_result['error'];
            header('Location: ' . BASE_URL . 'views/karyawan-form.php');
            exit;
        }
    }

    $karyawan_model->add($nama, $divisi, $id_jabatan, $id_rating, $alamat, $umur, $jenis_kelamin, $status, $aktif, $image_path);
    $_SESSION['success'] = 'Karyawan berhasil ditambahkan!';
    header('Location: ' . BASE_URL . 'views/karyawan.php');
    exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $divisi = $_POST['divisi'] ?? '';
    $id_jabatan = $_POST['id_jabatan'] ?? '';
    $id_rating = $_POST['id_rating'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $umur = $_POST['umur'] ?? '';
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $status = $_POST['status'] ?? '';
    $aktif = isset($_POST['aktif']) ? 1 : 0;

    if (empty($id) || empty($nama) || empty($divisi) || empty($id_jabatan) || empty($id_rating)) {
        $_SESSION['error'] = 'Data tidak lengkap.';
        header('Location: ' . BASE_URL . 'views/karyawan.php');
        exit;
    }

    $image_path = null;
    $existing_image = $_POST['existing_image'] ?? '1';

    // Get current employee data
    $current_employee = $karyawan_model->getById($id);

    // Handle file upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
        $upload_result = $file_handler->upload('photo');
        if ($upload_result['success']) {
            // Delete old image if exists (use server path)
            if (!empty($current_employee['path_image'])) {
                $server_old = __DIR__ . '/../' . $current_employee['path_image'];
                if (file_exists($server_old)) {
                    $file_handler->delete($server_old);
                }
            }
            $image_path = 'assets/images/employees/' . $upload_result['filename'];
        } else {
            $_SESSION['error'] = 'Upload gambar gagal: ' . $upload_result['error'];
            header('Location: ' . BASE_URL . 'views/karyawan-form.php?id=' . $id);
            exit;
        }
    } elseif ($existing_image === '0' && !empty($current_employee['path_image'])) {
        // Delete image if user removed it (use server path)
        $server_old = __DIR__ . '/../' . $current_employee['path_image'];
        if (file_exists($server_old)) {
            $file_handler->delete($server_old);
        }
        $image_path = null;
    }

    $karyawan_model->update($id, $nama, $divisi, $id_jabatan, $id_rating, $alamat, $umur, $jenis_kelamin, $status, $aktif, $image_path);
    $_SESSION['success'] = 'Data karyawan berhasil diperbarui!';
    header('Location: ' . BASE_URL . 'views/karyawan-detail.php?id=' . $id);
    exit;
}

if ($action === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $employee = $karyawan_model->getById($id);

    // Delete image file if exists (use server path)
    if (!empty($employee['path_image'])) {
        $server_file = __DIR__ . '/../' . $employee['path_image'];
        if (file_exists($server_file)) {
            $file_handler->delete($server_file);
        }
    }

    $karyawan_model->delete($id);
    $_SESSION['success'] = 'Karyawan berhasil dihapus!';
    header('Location: ' . BASE_URL . 'views/karyawan.php');
    exit;
}

if ($action === 'bulk_delete' && isset($_GET['ids'])) {
    $ids = array_map('intval', array_filter(explode(',', $_GET['ids'])));

    foreach ($ids as $id) {
        $employee = $karyawan_model->getById($id);

        // Delete image file if exists (use server path)
        if (!empty($employee['path_image'])) {
            $server_file = __DIR__ . '/../' . $employee['path_image'];
            if (file_exists($server_file)) {
                $file_handler->delete($server_file);
            }
        }

        $karyawan_model->delete($id);
    }

    $_SESSION['success'] = count($ids) . ' karyawan berhasil dihapus!';
    header('Location: ' . BASE_URL . 'views/karyawan.php');
    exit;
}

header('Location: ' . BASE_URL . 'views/karyawan.php');
?>
