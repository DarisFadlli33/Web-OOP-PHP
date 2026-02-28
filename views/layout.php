<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Sistem Manajemen Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar Overlay (untuk mobile) -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="brand">
                <h3><i class="fas fa-users"></i> HRM</h3>
                <small>Human Resource Management</small>
            </div>
            <ul class="nav-menu">
                <li>
                    <a href="<?php echo BASE_URL; ?>index.php" class="nav-link <?php echo (isset($current_page) && $current_page === 'dashboard') ? 'active' : ''; ?>">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo BASE_URL; ?>views/karyawan.php" class="nav-link <?php echo (isset($current_page) && $current_page === 'karyawan') ? 'active' : ''; ?>">
                        <i class="fas fa-users"></i>
                        <span>Daftar Karyawan</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo BASE_URL; ?>views/jabatan.php" class="nav-link <?php echo (isset($current_page) && $current_page === 'jabatan') ? 'active' : ''; ?>">
                        <i class="fas fa-briefcase"></i>
                        <span>Daftar Jabatan</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo BASE_URL; ?>views/rating.php" class="nav-link <?php echo (isset($current_page) && $current_page === 'rating') ? 'active' : ''; ?>">
                        <i class="fas fa-star"></i>
                        <span>Daftar Rating</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo BASE_URL; ?>views/lembur.php" class="nav-link <?php echo (isset($current_page) && $current_page === 'lembur') ? 'active' : ''; ?>">
                        <i class="fas fa-clock"></i>
                        <span>Tarif Lembur</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo BASE_URL; ?>views/gaji.php" class="nav-link <?php echo (isset($current_page) && $current_page === 'gaji') ? 'active' : ''; ?>">
                        <i class="fas fa-money-bill"></i>
                        <span>Gaji Karyawan</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-wrapper">
            <!-- Topbar -->
            <div class="topbar">
                <div class="topbar-left">
                    <button class="hamburger-btn" id="hamburgerBtn" title="Toggle Menu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h6 class="mb-0">
                        <i class="fas fa-home"></i>
                        <?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Dashboard'; ?>
                    </h6>
                </div>
                <div class="topbar-right">
                    <div class="dropdown" style="display: inline-block; margin-right: 20px;">
                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip" data-bs-title="Menu aksi cepat">
                            <i class="fas fa-cog"></i> Menu
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu">
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>index.php"><i class="fas fa-home"></i> Dashboard</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>views/karyawan.php"><i class="fas fa-users"></i> Daftar Karyawan</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>views/jabatan.php"><i class="fas fa-briefcase"></i> Daftar Jabatan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>views/karyawan.php" onclick="showToast('Fitur ekspor akan ditambahkan segera', 'info'); return false;"><i class="fas fa-download"></i> Ekspor Data</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>views/karyawan.php" onclick="showToast('Fitur laporan akan ditambahkan segera', 'info'); return false;"><i class="fas fa-file-pdf"></i> Buat Laporan</a></li>
                        </ul>
                    </div>
                    <span class="text-muted">
                        <i class="fas fa-clock"></i>
                        <span id="currentTime"><?php echo date('d M Y, H:i'); ?></span>
                    </span>
                </div>
            </div>

            <!-- Breadcrumb -->
            <?php if (isset($breadcrumb) && !empty($breadcrumb)): ?>
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo BASE_URL; ?>index.php">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <?php foreach ($breadcrumb as $item): ?>
                        <?php if (isset($item['url'])): ?>
                            <li class="breadcrumb-item">
                                <a href="<?php echo $item['url']; ?>">
                                    <?php if (isset($item['icon'])): ?>
                                        <i class="fas fa-<?php echo $item['icon']; ?>"></i>
                                    <?php endif; ?>
                                    <?php echo $item['label']; ?>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?php if (isset($item['icon'])): ?>
                                    <i class="fas fa-<?php echo $item['icon']; ?>"></i>
                                <?php endif; ?>
                                <?php echo $item['label']; ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </nav>
            <?php endif; ?>

            <!-- Page Content -->
            <div class="page-content">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['warning'])): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> <?php echo $_SESSION['warning']; unset($_SESSION['warning']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Content akan diisi di sini -->
