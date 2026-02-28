<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Karyawan.php';

$karyawan_model = new Karyawan();

$page_title = 'Detail Karyawan';
$current_page = 'karyawan';
$breadcrumb = [
    ['label' => 'Daftar Karyawan', 'url' => BASE_URL . 'views/karyawan.php', 'icon' => 'users'],
    ['label' => 'Detail Karyawan', 'icon' => 'user-circle']
];

if (!isset($_GET['id'])) {
    $_SESSION['error'] = 'ID Karyawan tidak ditemukan';
    header('Location: ' . BASE_URL . 'views/karyawan.php');
    exit;
}

$data = $karyawan_model->getById($_GET['id']);

if (!$data) {
    $_SESSION['error'] = 'Karyawan tidak ditemukan';
    header('Location: ' . BASE_URL . 'views/karyawan.php');
    exit;
}

include __DIR__ . '/layout.php';
?>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-user-circle"></i> Detail Karyawan</h5>
                <div>
                    <a href="<?php echo BASE_URL; ?>views/karyawan-form.php?id=<?php echo $data['id']; ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?php echo BASE_URL; ?>views/karyawan.php" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Nav Tabs -->
                <ul class="nav nav-tabs mb-4" id="detailTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal-content" type="button" role="tab" aria-controls="personal-content" aria-selected="true">
                            <i class="fas fa-user-tag"></i> Informasi Personal
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="work-tab" data-bs-toggle="tab" data-bs-target="#work-content" type="button" role="tab" aria-controls="work-content" aria-selected="false">
                            <i class="fas fa-briefcase"></i> Informasi Pekerjaan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="salary-tab" data-bs-toggle="tab" data-bs-target="#salary-content" type="button" role="tab" aria-controls="salary-content" aria-selected="false">
                            <i class="fas fa-money-bill"></i> Gaji & Tunjangan
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="detailTabContent">
                    <!-- Personal Tab -->
                    <div class="tab-pane fade show active" id="personal-content" role="tabpanel" aria-labelledby="personal-tab">
                        <div class="row">
                            <?php if (!empty($data['path_image']) && file_exists(__DIR__ . '/../' . $data['path_image'])): ?>
                            <div class="col-md-4 text-center mb-4">
                                <div class="card border-light">
                                    <div class="card-body p-3">
                                        <img src="<?php echo BASE_URL . htmlspecialchars($data['path_image']); ?>" alt="<?php echo htmlspecialchars($data['nama']); ?>" class="rounded" style="width: 100%; height: auto; max-height: 300px; object-fit: cover;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                            <?php else: ?>
                            <div class="col-md-4 text-center mb-4">
                                <div class="card border-light">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center justify-content-center" style="width: 100%; height: 300px; background-color: #e9ecef;">
                                            <div class="text-center">
                                                <i class="fas fa-user-circle" style="font-size: 80px; color: #999;"></i>
                                                <p class="text-muted mt-2">Tidak ada foto</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                            <?php endif; ?>
                                <p><strong>Nama Lengkap:</strong></p>
                                <p class="text-muted mb-3"><?php echo htmlspecialchars($data['nama']); ?></p>

                                <p><strong>Umur:</strong></p>
                                <p class="text-muted mb-3"><?php echo $data['umur'] ? htmlspecialchars($data['umur']) . ' tahun' : '-'; ?></p>

                                <p><strong>Jenis Kelamin:</strong></p>
                                <p class="text-muted mb-3"><?php echo htmlspecialchars($data['jenis_kelamin']) ?: '-'; ?></p>

                                <p><strong>Status Pernikahan:</strong></p>
                                <p class="text-muted mb-3"><?php echo htmlspecialchars($data['status']) ?: '-'; ?></p>

                                <p><strong>Tanggal Bergabung:</strong></p>
                                <p class="text-muted mb-3"><?php echo date('d M Y', strtotime($data['created_at'])); ?></p>

                                <p><strong>Alamat:</strong></p>
                                <p class="text-muted"><?php echo htmlspecialchars($data['alamat']) ?: '-'; ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Work Tab -->
                    <div class="tab-pane fade" id="work-content" role="tabpanel" aria-labelledby="work-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Divisi:</strong></p>
                                <p class="text-muted mb-3"><?php echo htmlspecialchars($data['divisi']); ?></p>

                                <p><strong>Jabatan:</strong></p>
                                <p class="text-muted"><?php echo htmlspecialchars($data['jabatan_nama']); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Rating Kinerja:</strong></p>
                                <p class="text-muted mb-3">
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-star"></i> <?php echo $data['rating']; ?>/5
                                    </span>
                                </p>

                                <p><strong>Bonus Kinerja:</strong></p>
                                <p class="text-muted"><?php echo $data['presentase_bonus']; ?>% dari Gaji Pokok</p>
                            </div>
                        </div>
                    </div>

                    <!-- Salary Tab -->
                    <div class="tab-pane fade" id="salary-content" role="tabpanel" aria-labelledby="salary-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Gaji Pokok:</strong></p>
                                <p class="text-muted mb-3"><?php echo 'Rp ' . number_format($data['gaji_pokok'], 0, ',', '.'); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Tunjangan Tetap:</strong></p>
                                <p class="text-muted mb-3"><?php echo 'Rp ' . number_format($data['tunjangan'], 0, ',', '.'); ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="alert alert-info mb-0">
                            <strong><i class="fas fa-calculator"></i> Total Kompensasi Dasar:</strong><br>
                            <h5 class="mt-2">Rp <?php echo number_format($data['gaji_pokok'] + $data['tunjangan'], 0, ',', '.'); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layout-footer.php'; ?>
