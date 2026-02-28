<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Jabatan.php';

$jabatan_model = new Jabatan();

$page_title = 'Detail Jabatan';
$current_page = 'jabatan';

if (!isset($_GET['id'])) {
    $_SESSION['error'] = 'ID Jabatan tidak ditemukan';
    header('Location: ' . BASE_URL . 'views/jabatan.php');
    exit;
}

$data = $jabatan_model->getById($_GET['id']);

if (!$data) {
    $_SESSION['error'] = 'Jabatan tidak ditemukan';
    header('Location: ' . BASE_URL . 'views/jabatan.php');
    exit;
}

include __DIR__ . '/layout.php';
?>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-briefcase"></i> Detail Jabatan</h5>
                <div>
                    <a href="<?php echo BASE_URL; ?>views/jabatan-form.php?id=<?php echo $data['id']; ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?php echo BASE_URL; ?>views/jabatan.php" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Nama Jabatan:</strong></p>
                        <p class="text-muted"><?php echo htmlspecialchars($data['nama']); ?></p>

                        <p><strong>Gaji Pokok:</strong></p>
                        <p class="text-muted text-success" style="font-size: 1.3rem;">
                            <strong><?php echo 'Rp ' . number_format($data['gaji_pokok'], 0, ',', '.'); ?></strong>
                        </p>
                    </div>

                    <div class="col-md-6">
                        <p><strong>Tunjangan Tetap:</strong></p>
                        <p class="text-muted text-info" style="font-size: 1.3rem;">
                            <strong><?php echo 'Rp ' . number_format($data['tunjangan'], 0, ',', '.'); ?></strong>
                        </p>

                        <p><strong>Total (Pokok + Tunjangan):</strong></p>
                        <p class="text-muted text-primary" style="font-size: 1.4rem;">
                            <strong><?php echo 'Rp ' . number_format($data['gaji_pokok'] + $data['tunjangan'], 0, ',', '.'); ?></strong>
                        </p>
                    </div>
                </div>

                <hr>

                <p><strong>Tanggal Dibuat:</strong></p>
                <p class="text-muted"><?php echo date('d M Y H:i', strtotime($data['created_at'])); ?></p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layout-footer.php'; ?>
