<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Rating.php';

$rating_model = new Rating();

$page_title = 'Daftar Rating';
$current_page = 'rating';
$breadcrumb = [
    ['label' => 'Daftar Rating', 'icon' => 'star']
];

$all_rating = $rating_model->getAll();

include __DIR__ . '/layout.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-star"></i> Daftar Rating</h3>
    <a href="<?php echo BASE_URL; ?>views/rating-form.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Rating
    </a>
</div>

<?php if (count($all_rating) > 0): ?>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Rating</th>
                        <th>Presentase Bonus</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_rating as $index => $item): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-star"></i> <?php echo $item['rating']; ?>/5
                                </span>
                            </td>
                            <td><?php echo $item['presentase_bonus']; ?>%</td>
                            <td>
                                <?php
                                $deskripsi = match($item['rating']) {
                                    5 => 'Sangat Baik',
                                    4 => 'Baik',
                                    3 => 'Cukup',
                                    2 => 'Kurang',
                                    1 => 'Sangat Kurang',
                                    default => '-'
                                };
                                echo $deskripsi;
                                ?>
                            </td>
                            <td class="action-buttons">
                                <a href="<?php echo BASE_URL; ?>views/rating-detail.php?id=<?php echo $item['id']; ?>" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>views/rating-form.php?id=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm" onclick="showDeleteConfirm('<?php echo BASE_URL; ?>controllers/rating-controller.php?action=delete&id=<?php echo $item['id']; ?>', 'Rating <?php echo $item['rating']; ?>');" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <div class="card">
        <div class="no-data">
            <i class="fas fa-inbox"></i>
            <p>Belum ada data rating</p>
            <a href="<?php echo BASE_URL; ?>views/rating-form.php" class="btn btn-primary btn-sm mt-3">
                <i class="fas fa-plus"></i> Tambah Rating
            </a>
        </div>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/layout-footer.php'; ?>
