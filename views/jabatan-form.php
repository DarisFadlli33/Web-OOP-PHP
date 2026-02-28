<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Jabatan.php';

$jabatan_model = new Jabatan();

$page_title = 'Form Jabatan';
$current_page = 'jabatan';

$is_edit = false;
$data = [
    'id' => '',
    'nama' => '',
    'gaji_pokok' => '',
    'tunjangan' => ''
];

if (isset($_GET['id'])) {
    $is_edit = true;
    $data = $jabatan_model->getById($_GET['id']);
    if (!$data) {
        $_SESSION['error'] = 'Jabatan tidak ditemukan';
        header('Location: ' . BASE_URL . 'views/jabatan.php');
        exit;
    }
}

include __DIR__ . '/layout.php';
?>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-briefcase"></i>
                    <?php echo $is_edit ? 'Edit Jabatan' : 'Tambah Jabatan Baru'; ?>
                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo BASE_URL; ?>controllers/jabatan-controller.php" method="POST">
                    <?php if ($is_edit): ?>
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                    <?php else: ?>
                        <input type="hidden" name="action" value="add">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label" for="nama">Nama Jabatan *</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
                        <small class="text-muted">Contoh: Manajer, Supervisor, Staff</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="gaji_pokok">Gaji Pokok (Rp) *</label>
                            <input type="number" class="form-control" id="gaji_pokok" name="gaji_pokok" value="<?php echo $data['gaji_pokok']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tunjangan">Tunjangan (Rp) *</label>
                            <input type="number" class="form-control" id="tunjangan" name="tunjangan" value="<?php echo $data['tunjangan']; ?>" required>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <strong>Total: </strong>
                        <span id="total_gaji">Rp 0</span>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> <?php echo $is_edit ? 'Update' : 'Simpan'; ?>
                        </button>
                        <a href="<?php echo BASE_URL; ?>views/jabatan.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const gajiPokok = document.getElementById('gaji_pokok');
    const tunjangan = document.getElementById('tunjangan');
    const totalGaji = document.getElementById('total_gaji');

    function updateTotal() {
        const pokok = parseInt(gajiPokok.value) || 0;
        const tun = parseInt(tunjangan.value) || 0;
        const total = pokok + tun;
        totalGaji.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    gajiPokok.addEventListener('input', updateTotal);
    tunjangan.addEventListener('input', updateTotal);
    updateTotal();
});
</script>

<?php include __DIR__ . '/layout-footer.php'; ?>
