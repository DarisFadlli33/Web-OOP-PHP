<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Gaji.php';
require_once __DIR__ . '/../models/Karyawan.php';
require_once __DIR__ . '/../models/Lembur.php';

$gaji_model = new Gaji();
$karyawan_model = new Karyawan();
$lembur_model = new Lembur();

$page_title = 'Form Gaji Karyawan';
$current_page = 'gaji';

$is_edit = false;
$data = [
    'id' => '',
    'id_karyawan' => '',
    'id_lembur' => '',
    'periode' => date('Y'),
    'lama_lembur' => '',
    'total_lembur' => '',
    'total_bonus' => '',
    'total_tunjangan' => '',
    'total_pendapatan' => '',
    'presentase_bonus' => '-'
];

$all_karyawan = $karyawan_model->getAll();
$all_lembur = $lembur_model->getAll();

if (isset($_GET['id'])) {
    $is_edit = true;
    $data = $gaji_model->getById($_GET['id']);
    if (!$data) {
        $_SESSION['error'] = 'Data gaji tidak ditemukan';
        header('Location: ' . BASE_URL . 'views/gaji.php');
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
                    <i class="fas fa-money-bill"></i>
                    <?php echo $is_edit ? 'Edit Perhitungan Gaji' : 'Hitung Gaji Karyawan'; ?>
                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo BASE_URL; ?>controllers/gaji-controller.php" method="POST">
                    <?php if ($is_edit): ?>
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                    <?php else: ?>
                        <input type="hidden" name="action" value="add">
                    <?php endif; ?>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="id_karyawan">Pilih Karyawan *</label>
                            <select class="form-control" id="id_karyawan" name="id_karyawan" required onchange="loadKaryawanData();">
                                <option value="">-- Pilih Karyawan --</option>
                                <?php foreach ($all_karyawan as $karyawan): ?>
                                    <option value="<?php echo $karyawan['id']; ?>" data-gaji="<?php echo $karyawan['gaji_pokok']; ?>" data-tunjangan="<?php echo $karyawan['tunjangan']; ?>" data-bonus="<?php echo $karyawan['presentase_bonus']; ?>" <?php echo ($data['id_karyawan'] == $karyawan['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($karyawan['nama']); ?> - <?php echo htmlspecialchars($karyawan['jabatan_nama']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="periode">Periode (Tahun) *</label>
                            <input type="number" class="form-control" id="periode" name="periode" value="<?php echo $data['periode']; ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="id_lembur">Tarif Lembur *</label>
                            <select class="form-control" id="id_lembur" name="id_lembur" required>
                                <option value="">-- Pilih Tarif Lembur --</option>
                                <?php foreach ($all_lembur as $lembur): ?>
                                    <option value="<?php echo $lembur['id']; ?>" data-tarif="<?php echo $lembur['tarif']; ?>" <?php echo ($data['id_lembur'] == $lembur['id']) ? 'selected' : ''; ?>>
                                        Rp <?php echo number_format($lembur['tarif'], 0, ',', '.'); ?>/jam
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="lama_lembur">Jam Lembur *</label>
                            <input type="number" class="form-control" id="lama_lembur" name="lama_lembur" value="<?php echo $data['lama_lembur']; ?>" required onchange="calculateGaji();" oninput="calculateGaji();">
                        </div>
                    </div>

                    <div class="card mt-4 mb-4">
                        <div class="card-header bg-primary">
                            <h6 class="mb-0">Rincian Gaji</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p><strong>Gaji Pokok:</strong></p>
                                    <p class="text-muted" id="display_gaji_pokok">-</p>
                                    <input type="hidden" id="gaji_pokok" value="">
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Tunjangan Tetap:</strong></p>
                                    <p class="text-muted" id="display_tunjangan">-</p>
                                    <input type="hidden" id="tunjangan" value="">
                                </div>
                            </div>

                            <hr>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p><strong>Total Lembur:</strong></p>
                                    <p class="text-muted" id="display_total_lembur">-</p>
                                    <input type="hidden" id="total_lembur" name="total_lembur" value="">
                                </div>
                                <div class="col-md-6">
                                    <p><strong id="bonus_label">Bonus (<?php echo $data['presentase_bonus']; ?>%):</strong></p>
                                    <p class="text-muted" id="display_bonus">-</p>
                                    <input type="hidden" id="total_bonus" name="total_bonus" value="">
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <h5><strong>TOTAL GAJI:</strong></h5>
                                    <h4 class="text-success" id="display_total_gaji">Rp 0</h4>
                                    <input type="hidden" id="total_pendapatan" name="total_pendapatan" value="">
                                    <input type="hidden" id="total_tunjangan_input" name="total_tunjangan" value="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> <?php echo $is_edit ? 'Update' : 'Simpan'; ?>
                        </button>
                        <a href="<?php echo BASE_URL; ?>views/gaji.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function loadKaryawanData() {
    const select = document.getElementById('id_karyawan');
    const selectedOption = select.options[select.selectedIndex];

    if (selectedOption.value) {
        const gajiPokok = parseInt(selectedOption.getAttribute('data-gaji')) || 0;
        const tunjangan = parseInt(selectedOption.getAttribute('data-tunjangan')) || 0;
        const bonusPersentase = parseInt(selectedOption.getAttribute('data-bonus')) || 0;

        document.getElementById('gaji_pokok').value = gajiPokok;
        document.getElementById('tunjangan').value = tunjangan;
        document.getElementById('display_gaji_pokok').textContent = 'Rp ' + gajiPokok.toLocaleString('id-ID');
        document.getElementById('display_tunjangan').textContent = 'Rp ' + tunjangan.toLocaleString('id-ID');
        document.getElementById('total_tunjangan_input').value = tunjangan;

        // Update bonus display
        document.getElementById('bonus_label').textContent = 'Bonus (' + bonusPersentase + '%):';

        calculateGaji();
    }
}

function calculateGaji() {
    const gajiPokok = parseInt(document.getElementById('gaji_pokok').value) || 0;
    const tunjangan = parseInt(document.getElementById('tunjangan').value) || 0;
    const lameLembur = parseInt(document.getElementById('lama_lembur').value) || 0;

    const tarifSelect = document.getElementById('id_lembur');
    const selectedOption = tarifSelect.options[tarifSelect.selectedIndex];
    const tarifLembur = parseInt(selectedOption.getAttribute('data-tarif')) || 0;

    const selectKaryawan = document.getElementById('id_karyawan');
    const selectedKaryawanOption = selectKaryawan.options[selectKaryawan.selectedIndex];
    const bonusPersentase = parseInt(selectedKaryawanOption.getAttribute('data-bonus')) || 0;

    // Calculate lembur and bonus
    const totalLembur = lameLembur * tarifLembur;
    const bonus = (gajiPokok * bonusPersentase) / 100;
    const totalGaji = gajiPokok + tunjangan + totalLembur + bonus;

    // Set hidden inputs
    document.getElementById('total_lembur').value = totalLembur;
    document.getElementById('total_bonus').value = Math.round(bonus);
    document.getElementById('total_pendapatan').value = Math.round(totalGaji);
    document.getElementById('total_tunjangan_input').value = tunjangan;

    // Display
    document.getElementById('display_total_lembur').textContent = 'Rp ' + totalLembur.toLocaleString('id-ID');
    document.getElementById('display_bonus').textContent = 'Rp ' + Math.round(bonus).toLocaleString('id-ID');
    document.getElementById('display_total_gaji').textContent = 'Rp ' + Math.round(totalGaji).toLocaleString('id-ID');
}

document.addEventListener('DOMContentLoaded', loadKaryawanData);
</script>

<?php include __DIR__ . '/layout-footer.php'; ?>
