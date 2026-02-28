<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Gaji.php';

$gaji_model = new Gaji();

$page_title = 'Detail Gaji Karyawan';
$current_page = 'gaji';

if (!isset($_GET['id'])) {
    $_SESSION['error'] = 'ID Gaji tidak ditemukan';
    header('Location: ' . BASE_URL . 'views/gaji.php');
    exit;
}

$data = $gaji_model->getById($_GET['id']);

if (!$data) {
    $_SESSION['error'] = 'Data gaji tidak ditemukan';
    header('Location: ' . BASE_URL . 'views/gaji.php');
    exit;
}

include __DIR__ . '/layout.php';
?>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-money-bill"></i> Detail Gaji Karyawan</h5>
                <div>
                    <a href="<?php echo BASE_URL; ?>views/gaji-form.php?id=<?php echo $data['id']; ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?php echo BASE_URL; ?>views/gaji.php" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Nama Karyawan:</strong></p>
                        <p class="text-muted"><?php echo htmlspecialchars($data['karyawan_nama']); ?></p>

                        <p><strong>Divisi:</strong></p>
                        <p class="text-muted"><?php echo htmlspecialchars($data['divisi']); ?></p>

                        <p><strong>Jabatan:</strong></p>
                        <p class="text-muted"><?php echo htmlspecialchars($data['jabatan_nama']); ?></p>
                    </div>

                    <div class="col-md-6">
                        <p><strong>Periode:</strong></p>
                        <p class="text-muted"><?php echo $data['periode']; ?></p>

                        <p><strong>Jam Lembur:</strong></p>
                        <p class="text-muted"><?php echo $data['lama_lembur']; ?> Jam</p>

                        <p><strong>Tanggal:</strong></p>
                        <p class="text-muted"><?php echo date('d M Y H:i', strtotime($data['created_at'])); ?></p>
                    </div>
                </div>

                <hr>

                <div class="card mt-4 mb-4">
                    <div class="card-header bg-primary">
                        <h6 class="mb-0">Rincian Gaji</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Gaji Pokok:</strong></p>
                                <p class="text-muted" style="font-size: 1.1rem;">
                                    <?php echo 'Rp ' . number_format($data['gaji_pokok'], 0, ',', '.'); ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Tunjangan Tetap:</strong></p>
                                <p class="text-muted" style="font-size: 1.1rem;">
                                    <?php echo 'Rp ' . number_format($data['total_tunjangan'], 0, ',', '.'); ?>
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Total Lembur (<?php echo $data['lama_lembur']; ?> Jam):</strong></p>
                                <p class="text-muted" style="font-size: 1.1rem;">
                                    <?php echo 'Rp ' . number_format($data['total_lembur'], 0, ',', '.'); ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Bonus:</strong></p>
                                <p class="text-muted" style="font-size: 1.1rem;">
                                    <?php echo 'Rp ' . number_format($data['total_bonus'], 0, ',', '.'); ?>
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <p><strong>TOTAL GAJI PENDAPATAN:</strong></p>
                                <h3 class="text-success" style="font-size: 2rem;">
                                    <strong><?php echo 'Rp ' . number_format($data['total_pendapatan'], 0, ',', '.'); ?></strong>
                                </h3>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3">
                            <strong>Rumus Perhitungan:</strong><br>
                            Total Gaji = Gaji Pokok + Tunjangan + Total Lembur + Bonus<br>
                            Total Gaji = <?php echo number_format($data['gaji_pokok'], 0, ',', '.'); ?> + <?php echo number_format($data['total_tunjangan'], 0, ',', '.'); ?> + <?php echo number_format($data['total_lembur'], 0, ',', '.'); ?> + <?php echo number_format($data['total_bonus'], 0, ',', '.'); ?> = <?php echo number_format($data['total_pendapatan'], 0, ',', '.'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layout-footer.php'; ?>
