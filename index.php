<?php
session_start();

// Define base URL
define('BASE_URL', 'http://localhost/Database-PHP/');

// Load required files
require_once __DIR__ . '/models/Karyawan.php';
require_once __DIR__ . '/models/Jabatan.php';
require_once __DIR__ . '/models/Rating.php';
require_once __DIR__ . '/models/Lembur.php';
require_once __DIR__ . '/models/Gaji.php';

// Initialize models
$karyawan_model = new Karyawan();
$jabatan_model = new Jabatan();
$rating_model = new Rating();
$lembur_model = new Lembur();
$gaji_model = new Gaji();

// Set page variables
$page_title = 'Dashboard';
$current_page = 'dashboard';
$breadcrumb = []; // No breadcrumb for dashboard

// Get Dashboard Data
$total_karyawan = $karyawan_model->getTotalKaryawan();
$total_jabatan = count($jabatan_model->getAll());
$total_rating = count($rating_model->getAll());
$recent_karyawan = $karyawan_model->getRecent(5);

// layout header
include __DIR__ . '/views/layout.php';
?>

<!-- Dashboard Content -->
<div class="welcome-section">
    <h1><i class="fas fa-hand-wave"></i> Selamat Datang di Sistem Manajemen Karyawan</h1>
    <p>Platform untuk mengelola data karyawan, gaji, dan informasi terkait SDM</p>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="dashboard-card success">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="dashboard-number"><?php echo $total_karyawan; ?></div>
                    <div class="dashboard-title">Total Karyawan</div>
                </div>
                <i class="fas fa-users" style="font-size: 2.5rem; color: var(--success-color); opacity: 0.3;"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="dashboard-number"><?php echo $total_jabatan; ?></div>
                    <div class="dashboard-title">Total Jabatan</div>
                </div>
                <i class="fas fa-briefcase" style="font-size: 2.5rem; color: var(--primary-color); opacity: 0.3;"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="dashboard-card warning">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="dashboard-number"><?php echo $total_rating; ?></div>
                    <div class="dashboard-title">Total Rating</div>
                </div>
                <i class="fas fa-star" style="font-size: 2.5rem; color: var(--warning-color); opacity: 0.3;"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="dashboard-card danger">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="dashboard-number"><?php echo count($gaji_model->getAll()); ?></div>
                    <div class="dashboard-title">Total Gaji</div>
                </div>
                <i class="fas fa-money-bill" style="font-size: 2.5rem; color: var(--danger-color); opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Carousel Section -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-images"></i> Galeri Karyawan Terbaru</h5>
    </div>
    <div class="card-body">
        <?php if (count($recent_karyawan) > 0): ?>
            <div id="employeeCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-indicators">
                    <?php foreach ($recent_karyawan as $idx => $emp): ?>
                        <button type="button" data-bs-target="#employeeCarousel" data-bs-slide-to="<?php echo $idx; ?>" class="<?php echo $idx === 0 ? 'active' : ''; ?>" aria-label="Slide <?php echo $idx + 1; ?>"></button>
                    <?php endforeach; ?>
                </div>
                <div class="carousel-inner">
                    <?php foreach ($recent_karyawan as $idx => $emp): ?>
                        <div class="carousel-item <?php echo $idx === 0 ? 'active' : ''; ?>">
                            <div class="employee-carousel-content">
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-center">
                                        <div class="employee-avatar">
                                            <?php if (!empty($emp['path_image']) && file_exists(__DIR__ . '/' . $emp['path_image'])): ?>
                                                <img src="<?php echo BASE_URL . htmlspecialchars($emp['path_image']); ?>" alt="Foto <?php echo htmlspecialchars($emp['nama']); ?>" class="rounded-circle" style="width: 100px; height:100px; object-fit:cover;">
                                            <?php else: ?>
                                                <i class="fas fa-user-circle"></i>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h4 class="mb-2"><?php echo htmlspecialchars($emp['nama']); ?></h4>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <p class="text-muted mb-1"><small>Divisi</small></p>
                                                <p><strong><?php echo htmlspecialchars($emp['divisi']); ?></strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p class="text-muted mb-1"><small>Jabatan</small></p>
                                                <p><strong><?php echo htmlspecialchars($emp['jabatan_nama']); ?></strong></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="text-muted mb-1"><small>Rating</small></p>
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-star"></i> <?php echo $emp['rating']; ?>/5
                                                </span>
                                            </div>
                                            <div class="col-6">
                                                <p class="text-muted mb-1"><small>Bergabung</small></p>
                                                <p><strong><?php echo date('d M Y', strtotime($emp['created_at'])); ?></strong></p>
                                            </div>
                                        </div>
                                        <a href="<?php echo BASE_URL; ?>views/karyawan-detail.php?id=<?php echo $emp['id']; ?>" class="btn btn-primary btn-sm mt-3">
                                            <i class="fas fa-eye"></i> Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#employeeCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#employeeCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        <?php else: ?>
            <div class="no-data">
                <i class="fas fa-images"></i>
                <p>Belum ada data karyawan untuk ditampilkan</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Employees Section -->
<div class="card mt-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0"><i class="fas fa-user-plus"></i> Karyawan Terbaru</h5>
        </div>
        <a href="<?php echo BASE_URL; ?>views/karyawan.php" class="btn btn-light btn-sm">Lihat Semua</a>
    </div>
    <div class="card-body">
        <?php if (count($recent_karyawan) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Divisi</th>
                            <th>Jabatan</th>
                            <th>Rating</th>
                            <th>Tanggal Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_karyawan as $index => $item): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><strong><?php echo htmlspecialchars($item['nama']); ?></strong></td>
                                <td><?php echo htmlspecialchars($item['divisi']); ?></td>
                                <td><?php echo htmlspecialchars($item['jabatan_nama']); ?></td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-star"></i> <?php echo $item['rating']; ?>/5
                                    </span>
                                </td>
                                <td><?php echo date('d M Y', strtotime($item['created_at'])); ?></td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>views/karyawan-detail.php?id=<?php echo $item['id']; ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="no-data">
                <i class="fas fa-inbox"></i>
                <p>Belum ada data karyawan</p>
                <a href="<?php echo BASE_URL; ?>views/karyawan.php" class="btn btn-primary btn-sm mt-3">
                    <i class="fas fa-plus"></i> Tambah Karyawan Pertama
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
// layout footer
include __DIR__ . '/views/layout-footer.php';
?>
