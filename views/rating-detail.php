<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Rating.php';

$rating_model = new Rating();

$page_title = 'Detail Rating';
$current_page = 'rating';

if (!isset($_GET['id'])) {
    $_SESSION['error'] = 'ID Rating tidak ditemukan';
    header('Location: ' . BASE_URL . 'views/rating.php');
    exit;
}

$data = $rating_model->getById($_GET['id']);

if (!$data) {
    $_SESSION['error'] = 'Rating tidak ditemukan';
    header('Location: ' . BASE_URL . 'views/rating.php');
    exit;
}

$deskripsi = match($data['rating']) {
    5 => 'Sangat Baik - Kinerja Excellent',
    4 => 'Baik - Kinerja Sangat Memuaskan',
    3 => 'Cukup - Kinerja Rata-rata',
    2 => 'Kurang - Perlu Improvement',
    1 => 'Sangat Kurang - Perlu Perhatian Khusus',
    default => '-'
};

include __DIR__ . '/layout.php';
?>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-star"></i> Detail Rating</h5>
                <div>
                    <a href="<?php echo BASE_URL; ?>views/rating-form.php?id=<?php echo $data['id']; ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?php echo BASE_URL; ?>views/rating.php" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <p><strong>Rating:</strong></p>
                <p class="mb-3">
                    <span class="badge bg-warning text-dark" style="font-size: 1.2rem; padding: 0.5rem 1rem;">
                        <i class="fas fa-star"></i> <?php echo $data['rating']; ?>/5
                    </span>
                </p>

                <p><strong>Keterangan:</strong></p>
                <p class="text-muted"><?php echo $deskripsi; ?></p>

                <hr>

                <p><strong>Presentase Bonus:</strong></p>
                <p class="text-muted" style="font-size: 1.3rem;">
                    <strong><?php echo $data['presentase_bonus']; ?>%</strong>
                </p>

                <div class="alert alert-info mt-3">
                    <strong>Contoh Perhitungan:</strong><br>
                    Jika gaji pokok Rp 10.000.000, maka bonus = 10.000.000 × <?php echo $data['presentase_bonus']; ?>% = Rp <?php echo number_format(10000000 * $data['presentase_bonus'] / 100, 0, ',', '.'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layout-footer.php'; ?>
