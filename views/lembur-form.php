<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Lembur.php';

$lembur_model = new Lembur();

$page_title = 'Form Tarif Lembur';
$current_page = 'lembur';

$is_edit = false;
$data = [
    'id' => '',
    'tarif' => ''
];

if (isset($_GET['id'])) {
    $is_edit = true;
    $data = $lembur_model->getById($_GET['id']);
    if (!$data) {
        $_SESSION['error'] = 'Tarif lembur tidak ditemukan';
        header('Location: ' . BASE_URL . 'views/lembur.php');
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
                    <i class="fas fa-clock"></i>
                    <?php echo $is_edit ? 'Edit Tarif Lembur' : 'Tambah Tarif Lembur Baru'; ?>
                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo BASE_URL; ?>controllers/lembur-controller.php" method="POST">
                    <?php if ($is_edit): ?>
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                    <?php else: ?>
                        <input type="hidden" name="action" value="add">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label" for="tarif">Tarif Lembur per Jam (Rp) *</label>
                        <input type="number" class="form-control" id="tarif" name="tarif" value="<?php echo $data['tarif']; ?>" required onchange="updatePreview();" oninput="updatePreview();">
                        <small class="text-muted">Masukkan nilai tarif dalam Rupiah</small>
                    </div>

                    <div class="alert alert-info">
                        <strong>Contoh Perhitungan:</strong><br>
                        Jika tarif <span id="preview_tarif">0</span>/jam dan karyawan lembur 5 jam<br>
                        Total lembur = <span id="preview_total">0</span>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> <?php echo $is_edit ? 'Update' : 'Simpan'; ?>
                        </button>
                        <a href="<?php echo BASE_URL; ?>views/lembur.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function updatePreview() {
    const tarif = parseInt(document.getElementById('tarif').value) || 0;
    document.getElementById('preview_tarif').textContent = 'Rp ' + tarif.toLocaleString('id-ID');
    document.getElementById('preview_total').textContent = 'Rp ' + (tarif * 5).toLocaleString('id-ID');
}

document.addEventListener('DOMContentLoaded', updatePreview);
</script>

<?php include __DIR__ . '/layout-footer.php'; ?>
