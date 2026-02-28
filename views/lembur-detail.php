<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Lembur.php';

$lembur_model = new Lembur();

$page_title = 'Detail Tarif Lembur';
$current_page = 'lembur';

if (!isset($_GET['id'])) {
    $_SESSION['error'] = 'ID Tarif lembur tidak ditemukan';
    header('Location: ' . BASE_URL . 'views/lembur.php');
    exit;
}

$data = $lembur_model->getById($_GET['id']);

if (!$data) {
    $_SESSION['error'] = 'Tarif lembur tidak ditemukan';
    header('Location: ' . BASE_URL . 'views/lembur.php');
    exit;
}

include __DIR__ . '/layout.php';
?>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-clock"></i> Detail Tarif Lembur</h5>
                <div>
                    <a href="<?php echo BASE_URL; ?>views/lembur-form.php?id=<?php echo $data['id']; ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?php echo BASE_URL; ?>views/lembur.php" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <p><strong>Tarif Lembur per Jam:</strong></p>
                <p class="text-muted" style="font-size: 1.4rem;">
                    <strong><?php echo 'Rp ' . number_format($data['tarif'], 0, ',', '.'); ?>/jam</strong>
                </p>

                <hr>

                <p><strong>Contoh Perhitungan Lembur:</strong></p>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Jam Lembur</th>
                                <th>Total Gaji Lembur</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 8; $i++): ?>
                                <tr>
                                    <td><?php echo $i; ?> Jam</td>
                                    <td><?php echo 'Rp ' . number_format($data['tarif'] * $i, 0, ',', '.'); ?></td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>

                <div class="alert alert-info">
                    <strong>Rumus:</strong><br>
                    Total Lembur = Tarif/Jam × Jumlah Jam Lembur
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layout-footer.php'; ?>
