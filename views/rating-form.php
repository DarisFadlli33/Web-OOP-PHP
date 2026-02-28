<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Rating.php';

$rating_model = new Rating();

$page_title = 'Form Rating';
$current_page = 'rating';

$is_edit = false;
$data = [
    'id' => '',
    'rating' => '',
    'presentase_bonus' => ''
];

if (isset($_GET['id'])) {
    $is_edit = true;
    $data = $rating_model->getById($_GET['id']);
    if (!$data) {
        $_SESSION['error'] = 'Rating tidak ditemukan';
        header('Location: ' . BASE_URL . 'views/rating.php');
        exit;
    }
}

include __DIR__ . '/layout.php';
?>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-star"></i>
                    <?php echo $is_edit ? 'Edit Rating' : 'Tambah Rating Baru'; ?>
                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo BASE_URL; ?>controllers/rating-controller.php" method="POST">
                    <?php if ($is_edit): ?>
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                    <?php else: ?>
                        <input type="hidden" name="action" value="add">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label" for="rating">Rating (Skala 1-5) *</label>
                        <select class="form-control" id="rating" name="rating" required>
                            <option value="">-- Pilih Rating --</option>
                            <option value="5" <?php echo ($data['rating'] == 5) ? 'selected' : ''; ?>>5 - Sangat Baik</option>
                            <option value="4" <?php echo ($data['rating'] == 4) ? 'selected' : ''; ?>>4 - Baik</option>
                            <option value="3" <?php echo ($data['rating'] == 3) ? 'selected' : ''; ?>>3 - Cukup</option>
                            <option value="2" <?php echo ($data['rating'] == 2) ? 'selected' : ''; ?>>2 - Kurang</option>
                            <option value="1" <?php echo ($data['rating'] == 1) ? 'selected' : ''; ?>>1 - Sangat Kurang</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="presentase_bonus">Presentase Bonus (%) *</label>
                        <input type="number" class="form-control" id="presentase_bonus" name="presentase_bonus" value="<?php echo $data['presentase_bonus']; ?>" min="0" max="100" required>
                        <small class="text-muted">Contoh: 20 untuk 20% bonus</small>
                    </div>

                    <div class="alert alert-info">
                        <strong>Bonus Dihitung Dari: </strong>Gaji Pokok × Presentase Bonus
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> <?php echo $is_edit ? 'Update' : 'Simpan'; ?>
                        </button>
                        <a href="<?php echo BASE_URL; ?>views/rating.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layout-footer.php'; ?>
