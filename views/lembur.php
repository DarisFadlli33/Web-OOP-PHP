<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Lembur.php';

$lembur_model = new Lembur();

$page_title = 'Tarif Lembur';
$current_page = 'lembur';
$breadcrumb = [
    ['label' => 'Tarif Lembur', 'icon' => 'clock']
];

$all_lembur = $lembur_model->getAll();

include __DIR__ . '/layout.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-clock"></i> Tarif Lembur</h3>
    <a href="<?php echo BASE_URL; ?>views/lembur-form.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Tarif Lembur
    </a>
</div>

<?php if (count($all_lembur) > 0): ?>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tarif per Jam</th>
                        <th>Contoh Total Lembur 5 Jam</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_lembur as $index => $item): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td>
                                <strong><?php echo 'Rp ' . number_format($item['tarif'], 0, ',', '.'); ?>/jam</strong>
                            </td>
                            <td><?php echo 'Rp ' . number_format($item['tarif'] * 5, 0, ',', '.'); ?></td>
                            <td class="action-buttons">
                                <a href="<?php echo BASE_URL; ?>views/lembur-detail.php?id=<?php echo $item['id']; ?>" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>views/lembur-form.php?id=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm" onclick="showDeleteConfirm('<?php echo BASE_URL; ?>controllers/lembur-controller.php?action=delete&id=<?php echo $item['id']; ?>', 'Tarif Rp <?php echo number_format($item['tarif'], 0, ',', '.'); ?>/jam');" title="Hapus">
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
            <p>Belum ada data tarif lembur</p>
            <a href="<?php echo BASE_URL; ?>views/lembur-form.php" class="btn btn-primary btn-sm mt-3">
                <i class="fas fa-plus"></i> Tambah Tarif Lembur
            </a>
        </div>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/layout-footer.php'; ?>
