<?php
/**
 * FILE TEST APLIKASI SISTEM MANAJEMEN KARYAWAN
 * Gunakan file ini untuk memverifikasi setup aplikasi
 * Akses: http://localhost/Database-PHP/test.php
 */

define('BASE_URL', 'http://localhost/Database-PHP/');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Aplikasi - Sistem Manajemen Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fc; padding: 30px 0; }
        .test-card { background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .test-header { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; padding: 20px; border-radius: 8px 8px 0 0; }
        .test-item { padding: 15px; border-bottom: 1px solid #e3e6f0; display: flex; justify-content: space-between; align-items: center; }
        .test-item:last-child { border-bottom: none; }
        .status-ok { color: #1cc88a; }
        .status-error { color: #e74c3c; }
        .status-warning { color: #f8b500; }
        .badge-ok { background-color: #1cc88a; }
        .badge-error { background-color: #e74c3c; }
        .badge-warning { background-color: #f8b500; }
    </style>
</head>
<body>
    <div class="container">
        <div class="test-card">
            <div class="test-header">
                <h2><i class="fas fa-stethoscope"></i> Test Aplikasi Sistem Manajemen Karyawan</h2>
                <p class="mb-0">Verifikasi Setup dan Konfigurasi</p>
            </div>
            <div>
                <!-- PHP Version -->
                <div class="test-item">
                    <div>
                        <strong>PHP Version</strong>
                        <br>
                        <small class="text-muted">Minimal: PHP 7.4</small>
                    </div>
                    <div>
                        <?php
                        $php_version = phpversion();
                        $is_ok = version_compare($php_version, '7.4', '>=');
                        ?>
                        <span class="badge <?php echo $is_ok ? 'badge-ok' : 'badge-error'; ?>">
                            <?php echo $php_version; ?>
                        </span>
                    </div>
                </div>

                <!-- MySQLi Extension -->
                <div class="test-item">
                    <div>
                        <strong>MySQLi Extension</strong>
                        <br>
                        <small class="text-muted">Diperlukan untuk koneksi database</small>
                    </div>
                    <div>
                        <span class="badge <?php echo extension_loaded('mysqli') ? 'badge-ok' : 'badge-error'; ?>">
                            <?php echo extension_loaded('mysqli') ? '✓ Loaded' : '✗ Not Loaded'; ?>
                        </span>
                    </div>
                </div>

                <!-- PDO Extension -->
                <div class="test-item">
                    <div>
                        <strong>PDO Extension</strong>
                        <br>
                        <small class="text-muted">Optional - untuk alternative database connection</small>
                    </div>
                    <div>
                        <span class="badge <?php echo extension_loaded('pdo') ? 'badge-ok' : 'badge-warning'; ?>">
                            <?php echo extension_loaded('pdo') ? '✓ Loaded' : '○ Not Loaded'; ?>
                        </span>
                    </div>
                </div>

                <!-- Session Support -->
                <div class="test-item">
                    <div>
                        <strong>Session Support</strong>
                        <br>
                        <small class="text-muted">Untuk session management</small>
                    </div>
                    <div>
                        <span class="badge badge-ok">
                            <?php echo ini_get('session.save_handler') != '' ? '✓ Enabled' : '✗ Disabled'; ?>
                        </span>
                    </div>
                </div>

                <!-- File Upload -->
                <div class="test-item">
                    <div>
                        <strong>File Upload Support</strong>
                        <br>
                        <small class="text-muted">Maksimal upload: <?php echo ini_get('upload_max_filesize'); ?></small>
                    </div>
                    <div>
                        <span class="badge badge-ok">
                            <?php echo ini_get('file_uploads') ? '✓ Enabled' : '✗ Disabled'; ?>
                        </span>
                    </div>
                </div>

                <!-- Database Connection Test -->
                <div class="test-item">
                    <div>
                        <strong>Database Connection</strong>
                        <br>
                        <small class="text-muted">Test koneksi ke database MySQL</small>
                    </div>
                    <div>
                        <?php
                        require_once 'config/Database.php';
                        try {
                            $db = new Database();
                            echo '<span class="badge badge-ok">✓ Connected</span>';
                        } catch (Exception $e) {
                            echo '<span class="badge badge-error">✗ Failed</span>';
                            echo '<br><small class="text-danger">' . htmlspecialchars($e->getMessage()) . '</small>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Check Tables -->
                <div class="test-item">
                    <div>
                        <strong>Database Tables</strong>
                        <br>
                        <small class="text-muted">Verifikasi tabel-tabel penting</small>
                    </div>
                    <div>
                        <?php
                        $tables = ['karyawan', 'jabatan', 'rating', 'lembur', 'gaji'];
                        $missing_tables = [];

                        if (isset($db)) {
                            foreach ($tables as $table) {
                                $result = $db->query("SHOW TABLES LIKE '$table'");
                                if (!$result || mysqli_num_rows($result) == 0) {
                                    $missing_tables[] = $table;
                                }
                            }
                        }

                        if (empty($missing_tables)) {
                            echo '<span class="badge badge-ok">✓ All Tables Present</span>';
                        } else {
                            echo '<span class="badge badge-warning">⚠ Missing Tables</span>';
                            echo '<br><small class="text-warning">Missing: ' . implode(', ', $missing_tables) . '</small>';
                        }
                        ?>
                    </div>
                </div>

                <!-- File Structure -->
                <div class="test-item">
                    <div>
                        <strong>Folder Structure</strong>
                        <br>
                        <small class="text-muted">Verifikasi struktur folder aplikasi</small>
                    </div>
                    <div>
                        <?php
                        $folders = ['config', 'classes', 'models', 'controllers', 'views', 'assets'];
                        $missing_folders = [];

                        foreach ($folders as $folder) {
                            if (!is_dir($folder)) {
                                $missing_folders[] = $folder;
                            }
                        }

                        if (empty($missing_folders)) {
                            echo '<span class="badge badge-ok">✓ Complete</span>';
                        } else {
                            echo '<span class="badge badge-error">✗ Incomplete</span>';
                            echo '<br><small class="text-danger">Missing: ' . implode(', ', $missing_folders) . '</small>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Model Files -->
                <div class="test-item">
                    <div>
                        <strong>Model Files</strong>
                        <br>
                        <small class="text-muted">Verifikasi file model</small>
                    </div>
                    <div>
                        <?php
                        $models = ['models/Karyawan.php', 'models/Jabatan.php', 'models/Rating.php', 'models/Lembur.php', 'models/Gaji.php'];
                        $missing_models = [];

                        foreach ($models as $model) {
                            if (!file_exists($model)) {
                                $missing_models[] = basename($model);
                            }
                        }

                        if (empty($missing_models)) {
                            echo '<span class="badge badge-ok">✓ Complete</span>';
                        } else {
                            echo '<span class="badge badge-error">✗ Missing</span>';
                            echo '<br><small class="text-danger">' . implode(', ', $missing_models) . '</small>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Controller Files -->
                <div class="test-item">
                    <div>
                        <strong>Controller Files</strong>
                        <br>
                        <small class="text-muted">Verifikasi file controller</small>
                    </div>
                    <div>
                        <?php
                        $controllers = ['controllers/karyawan-controller.php', 'controllers/jabatan-controller.php', 'controllers/rating-controller.php', 'controllers/lembur-controller.php', 'controllers/gaji-controller.php'];
                        $missing_controllers = [];

                        foreach ($controllers as $controller) {
                            if (!file_exists($controller)) {
                                $missing_controllers[] = basename($controller);
                            }
                        }

                        if (empty($missing_controllers)) {
                            echo '<span class="badge badge-ok">✓ Complete</span>';
                        } else {
                            echo '<span class="badge badge-error">✗ Missing</span>';
                            echo '<br><small class="text-danger">' . implode(', ', $missing_controllers) . '</small>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Assets Files -->
                <div class="test-item">
                    <div>
                        <strong>Asset Files</strong>
                        <br>
                        <small class="text-muted">CSS dan JavaScript</small>
                    </div>
                    <div>
                        <?php
                        $assets_ok = file_exists('assets/css/style.css') && file_exists('assets/js/main.js');
                        echo $assets_ok ? '<span class="badge badge-ok">✓ Complete</span>' : '<span class="badge badge-error">✗ Missing</span>';
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="test-card">
            <div class="test-header">
                <h5 class="mb-0">Kesimpulan</h5>
            </div>
            <div style="padding: 20px;">
                <?php
                $all_ok = extension_loaded('mysqli') &&
                          !empty($missing_tables) === false &&
                          empty($missing_folders) &&
                          empty($missing_models) &&
                          empty($missing_controllers) &&
                          $assets_ok;

                if ($all_ok) {
                    echo '<div class="alert alert-success"><i class="fas fa-check-circle"></i> <strong>Setup Berhasil!</strong> Aplikasi siap digunakan.</div>';
                    echo '<p><strong>Langkah selanjutnya:</strong></p>';
                    echo '<ul>';
                    echo '<li>Akses <a href="' . BASE_URL . '">Dashboard</a></li>';
                    echo '<li>Mulai dengan membuat Jabatan terlebih dahulu</li>';
                    echo '<li>Kemudian buat Rating dan Tarif Lembur</li>';
                    echo '<li>Setelah itu, daftarkan Karyawan baru</li>';
                    echo '<li>Terakhir, hitung Gaji Karyawan</li>';
                    echo '</ul>';
                } else {
                    echo '<div class="alert alert-danger"><i class="fas fa-times-circle"></i> <strong>Ada masalah dalam setup!</strong> Silakan perbaiki error di atas.</div>';
                }
                ?>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="test-card">
            <div class="test-header">
                <h5 class="mb-0">Quick Links</h5>
            </div>
            <div style="padding: 20px;">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Aplikasi</h6>
                        <ul>
                            <li><a href="<?php echo BASE_URL; ?>index.php">Dashboard</a></li>
                            <li><a href="<?php echo BASE_URL; ?>views/karyawan.php">Daftar Karyawan</a></li>
                            <li><a href="<?php echo BASE_URL; ?>views/gaji.php">Gaji Karyawan</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Manajemen Data</h6>
                        <ul>
                            <li><a href="<?php echo BASE_URL; ?>views/jabatan.php">Daftar Jabatan</a></li>
                            <li><a href="<?php echo BASE_URL; ?>views/rating.php">Daftar Rating</a></li>
                            <li><a href="<?php echo BASE_URL; ?>views/lembur.php">Tarif Lembur</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
