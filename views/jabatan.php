<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Jabatan.php';

$jabatan_model = new Jabatan();

$page_title = 'Daftar Jabatan';
$current_page = 'jabatan';
$breadcrumb = [
    ['label' => 'Daftar Jabatan', 'icon' => 'briefcase']
];

$all_jabatan = $jabatan_model->getAll();

include __DIR__ . '/layout.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-briefcase"></i> Daftar Jabatan</h3>
    <a href="<?php echo BASE_URL; ?>views/jabatan-form.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Jabatan
    </a>
</div>

<?php if (count($all_jabatan) > 0): ?>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Jabatan</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan</th>
                        <th>Total</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_jabatan as $index => $item): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><strong><?php echo htmlspecialchars($item['nama']); ?></strong></td>
                            <td><?php echo 'Rp ' . number_format($item['gaji_pokok'], 0, ',', '.'); ?></td>
                            <td><?php echo 'Rp ' . number_format($item['tunjangan'], 0, ',', '.'); ?></td>
                            <td><strong><?php echo 'Rp ' . number_format($item['gaji_pokok'] + $item['tunjangan'], 0, ',', '.'); ?></strong></td>
                            <td><?php echo date('d M Y', strtotime($item['created_at'])); ?></td>
                            <td class="action-buttons">
                                <a href="<?php echo BASE_URL; ?>views/jabatan-detail.php?id=<?php echo $item['id']; ?>" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>views/jabatan-form.php?id=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm" onclick="showDeleteConfirm('<?php echo BASE_URL; ?>controllers/jabatan-controller.php?action=delete&id=<?php echo $item['id']; ?>', '<?php echo addslashes($item['nama']); ?>');" title="Hapus">
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
            <p>Belum ada data jabatan</p>
            <a href="<?php echo BASE_URL; ?>views/jabatan-form.php" class="btn btn-primary btn-sm mt-3">
                <i class="fas fa-plus"></i> Tambah Jabatan
            </a>
        </div>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/layout-footer.php'; ?>
