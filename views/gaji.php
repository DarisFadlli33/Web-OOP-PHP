<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Gaji.php';

$gaji_model = new Gaji();

$page_title = 'Gaji Karyawan';
$current_page = 'gaji';
$breadcrumb = [
    ['label' => 'Gaji Karyawan', 'icon' => 'money-bill']
];

$all_gaji = $gaji_model->getAll();

include __DIR__ . '/layout.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-money-bill"></i> Gaji Karyawan</h3>
    <a href="<?php echo BASE_URL; ?>views/gaji-form.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Hitung Gaji
    </a>
</div>

<?php if (count($all_gaji) > 0): ?>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Jabatan</th>
                        <th>Periode</th>
                        <th>Total Pendapatan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_gaji as $index => $item): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><strong><?php echo htmlspecialchars($item['karyawan_nama']); ?></strong></td>
                            <td><?php echo htmlspecialchars($item['jabatan_nama']); ?></td>
                            <td><?php echo $item['periode']; ?></td>
                            <td><strong><?php echo 'Rp ' . number_format($item['total_pendapatan'], 0, ',', '.'); ?></strong></td>
                            <td><?php echo date('d M Y', strtotime($item['created_at'])); ?></td>
                            <td class="action-buttons">
                                <a href="<?php echo BASE_URL; ?>views/gaji-detail.php?id=<?php echo $item['id']; ?>" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>views/gaji-form.php?id=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm" onclick="showDeleteConfirm('<?php echo BASE_URL; ?>controllers/gaji-controller.php?action=delete&id=<?php echo $item['id']; ?>', '<?php echo addslashes($item['karyawan_nama']); ?> - <?php echo $item['periode']; ?>');" title="Hapus">
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
            <p>Belum ada data gaji</p>
            <a href="<?php echo BASE_URL; ?>views/gaji-form.php" class="btn btn-primary btn-sm mt-3">
                <i class="fas fa-plus"></i> Hitung Gaji
            </a>
        </div>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/layout-footer.php'; ?>
