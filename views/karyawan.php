<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Karyawan.php';
require_once __DIR__ . '/../models/Jabatan.php';
require_once __DIR__ . '/../models/Rating.php';

$karyawan_model = new Karyawan();
$jabatan_model = new Jabatan();
$rating_model = new Rating();

$page_title = 'Daftar Karyawan';
$current_page = 'karyawan';
$breadcrumb = [
    ['label' => 'Daftar Karyawan', 'icon' => 'users']
];

// Pagination
$items_per_page = 10;
$current_page_num = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($current_page_num - 1) * $items_per_page;

// Get all data
$all_karyawan = $karyawan_model->getAll();
$all_jabatan = $jabatan_model->getAll();
$all_rating = $rating_model->getAll();

// Calculate pagination
$total_items = count($all_karyawan);
$total_pages = ceil($total_items / $items_per_page);
$paginated_karyawan = array_slice($all_karyawan, $offset, $items_per_page);

include __DIR__ . '/layout.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-users"></i> Daftar Karyawan</h3>
    <div class="d-flex gap-2">
        <button id="bulkDeleteBtn" class="btn btn-danger btn-sm" style="display: none;" onclick="bulkDelete();" title="Hapus data yang dipilih">
            <i class="fas fa-trash"></i> Hapus Dipilih
        </button>
        <a href="<?php echo BASE_URL; ?>views/karyawan-form.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Karyawan
        </a>
    </div>
</div>

<?php if (count($all_karyawan) > 0): ?>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 40px;">
                            <input type="checkbox" class="form-check-input" id="selectAllCheckbox" onchange="toggleSelectAll(this);">
                        </th>
                        <th>No</th>
                        <th style="width: 80px;">Foto</th>
                        <th>Nama</th>
                        <th>Divisi</th>
                        <th>Jabatan</th>
                        <th>Rating</th>
                        <th>Tanggal Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($paginated_karyawan as $index => $item): ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input row-checkbox" value="<?php echo $item['id']; ?>" onchange="updateBulkDeleteBtn();">
                            </td>
                            <td><?php echo $offset + $index + 1; ?></td>
                            <td>
                                <?php if (!empty($item['path_image']) && file_exists(__DIR__ . '/../' . $item['path_image'])): ?>
                                    <img src="<?php echo BASE_URL . htmlspecialchars($item['path_image']); ?>" alt="<?php echo htmlspecialchars($item['nama']); ?>" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: #e9ecef;">
                                        <i class="fas fa-user text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><strong><?php echo htmlspecialchars($item['nama']); ?></strong></td>
                            <td><?php echo htmlspecialchars($item['divisi']); ?></td>
                            <td><?php echo htmlspecialchars($item['jabatan_nama']); ?></td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-star"></i> <?php echo $item['rating']; ?>
                                </span>
                            </td>
                            <td><?php echo date('d M Y', strtotime($item['created_at'])); ?></td>
                            <td class="action-buttons">
                                <a href="<?php echo BASE_URL; ?>views/karyawan-detail.php?id=<?php echo $item['id']; ?>" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>views/karyawan-form.php?id=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm" onclick="showDeleteConfirm('<?php echo BASE_URL; ?>controllers/karyawan-controller.php?action=delete&id=<?php echo $item['id']; ?>', '<?php echo addslashes($item['nama']); ?>');" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if ($total_pages > 1): ?>
        <nav aria-label="Pagination" class="p-3 border-top">
            <ul class="pagination pagination-sm mb-0 justify-content-center">
                <?php if ($current_page_num > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo BASE_URL; ?>views/karyawan.php?page=1" title="Halaman pertama">
                            <i class="fas fa-chevron-left"></i> Awal
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo BASE_URL; ?>views/karyawan.php?page=<?php echo $current_page_num - 1; ?>" title="Halaman sebelumnya">
                            Sebelumnya
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <?php if ($i === $current_page_num): ?>
                        <li class="page-item active">
                            <span class="page-link">
                                <?php echo $i; ?>
                                <span class="visually-hidden">(halaman saat ini)</span>
                            </span>
                        </li>
                    <?php elseif ($i <= 2 || $i >= $total_pages - 1 || abs($i - $current_page_num) <= 2): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo BASE_URL; ?>views/karyawan.php?page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php elseif ($i === 3 && $current_page_num > 5): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($current_page_num < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo BASE_URL; ?>views/karyawan.php?page=<?php echo $current_page_num + 1; ?>" title="Halaman berikutnya">
                            Berikutnya
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo BASE_URL; ?>views/karyawan.php?page=<?php echo $total_pages; ?>" title="Halaman terakhir">
                            Akhir <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="px-3 pb-2 text-muted text-sm">
            Menampilkan <?php echo $offset + 1; ?> hingga <?php echo min($offset + $items_per_page, $total_items); ?> dari <?php echo $total_items; ?> data
        </div>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="card">
        <div class="no-data">
            <i class="fas fa-inbox"></i>
            <p>Belum ada data karyawan</p>
            <a href="<?php echo BASE_URL; ?>views/karyawan-form.php" class="btn btn-primary btn-sm mt-3">
                <i class="fas fa-plus"></i> Tambah Karyawan
            </a>
        </div>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/layout-footer.php'; ?>

<script>
// Toggle Select All
function toggleSelectAll(selectAllCheckbox) {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    updateBulkDeleteBtn();
}

// Update Bulk Delete Button Visibility
function updateBulkDeleteBtn() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    const selectedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

    if (selectedCount > 0) {
        bulkDeleteBtn.style.display = 'inline-block';
        bulkDeleteBtn.innerHTML = '<i class="fas fa-trash"></i> Hapus (' + selectedCount + ') Dipilih';
    } else {
        bulkDeleteBtn.style.display = 'none';
    }
}

// Bulk Delete
function bulkDelete() {
    const checkboxes = document.querySelectorAll('.row-checkbox:checked');
    if (checkboxes.length === 0) {
        showToast('Pilih minimal satu data untuk dihapus', 'warning');
        return;
    }

    const ids = Array.from(checkboxes).map(cb => cb.value).join(',');
    showDeleteConfirm('<?php echo BASE_URL; ?>controllers/karyawan-controller.php?action=bulk_delete&ids=' + ids, 'Data yang dipilih');
}
</script>
