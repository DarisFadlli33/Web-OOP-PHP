<?php
session_start();

define('BASE_URL', 'http://localhost/Database-PHP/');

require_once __DIR__ . '/../models/Karyawan.php';
require_once __DIR__ . '/../models/Jabatan.php';
require_once __DIR__ . '/../models/Rating.php';

$karyawan_model = new Karyawan();
$jabatan_model = new Jabatan();
$rating_model = new Rating();

$page_title = 'Form Karyawan';
$current_page = 'karyawan';

$is_edit = false;
$data = [
    'id' => '',
    'nama' => '',
    'divisi' => '',
    'id_jabatan' => '',
    'id_rating' => '',
    'alamat' => '',
    'umur' => '',
    'jenis_kelamin' => '',
    'status' => '',
    'aktif' => 1,
    'path_image' => ''
];

// Check if edit mode
if (isset($_GET['id'])) {
    $is_edit = true;
    $data = $karyawan_model->getById($_GET['id']);
    if (!$data) {
        $_SESSION['error'] = 'Karyawan tidak ditemukan';
        header('Location: ' . BASE_URL . 'views/karyawan.php');
        exit;
    }
}

$breadcrumb = [
    ['label' => 'Daftar Karyawan', 'url' => BASE_URL . 'views/karyawan.php', 'icon' => 'users'],
    ['label' => $is_edit ? 'Edit Karyawan' : 'Tambah Karyawan', 'icon' => 'user-plus']
];

$all_jabatan = $jabatan_model->getAll();
$all_rating = $rating_model->getAll();

include __DIR__ . '/layout.php';
?>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user"></i>
                    <?php echo $is_edit ? 'Edit Karyawan' : 'Tambah Karyawan Baru'; ?>
                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo BASE_URL; ?>controllers/karyawan-controller.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <?php if ($is_edit): ?>
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                    <?php else: ?>
                        <input type="hidden" name="action" value="add">
                    <?php endif; ?>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="nama">Nama Lengkap *</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
                            <div class="invalid-feedback">
                                Nama lengkap harus diisi
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="umur">Umur</label>
                            <input type="number" class="form-control" id="umur" name="umur" value="<?php echo $data['umur']; ?>" min="18" max="65">
                            <div class="invalid-feedback">
                                Umur harus antara 18-65 tahun
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" <?php echo ($data['jenis_kelamin'] === 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="Perempuan" <?php echo ($data['jenis_kelamin'] === 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">-- Pilih --</option>
                                <option value="Menikah" <?php echo ($data['status'] === 'Menikah') ? 'selected' : ''; ?>>Menikah</option>
                                <option value="Belum Menikah" <?php echo ($data['status'] === 'Belum Menikah') ? 'selected' : ''; ?>>Belum Menikah</option>
                                <option value="Cerai" <?php echo ($data['status'] === 'Cerai') ? 'selected' : ''; ?>>Cerai</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="divisi">Divisi *</label>
                            <input type="text" class="form-control" id="divisi" name="divisi" value="<?php echo htmlspecialchars($data['divisi']); ?>" required>
                            <div class="invalid-feedback">
                                Divisi harus diisi
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="id_jabatan">Jabatan *</label>
                            <select class="form-control" id="id_jabatan" name="id_jabatan" required>
                                <option value="">-- Pilih Jabatan --</option>
                                <?php foreach ($all_jabatan as $jabatan): ?>
                                    <option value="<?php echo $jabatan['id']; ?>" <?php echo ($data['id_jabatan'] == $jabatan['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($jabatan['nama']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Jabatan harus dipilih
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="id_rating">Rating *</label>
                            <select class="form-control" id="id_rating" name="id_rating" required>
                                <option value="">-- Pilih Rating --</option>
                                <?php foreach ($all_rating as $rating): ?>
                                    <option value="<?php echo $rating['id']; ?>" <?php echo ($data['id_rating'] == $rating['id']) ? 'selected' : ''; ?>>
                                        Rating <?php echo $rating['rating']; ?> (<?php echo $rating['presentase_bonus']; ?>% Bonus)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Rating harus dipilih
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3"><?php echo htmlspecialchars($data['alamat']); ?></textarea>
                    </div>

                    <div class="form-group-image">
                        <label class="form-label">Foto Karyawan</label>
                        <div class="image-upload-wrapper">
                            <div id="imageUploadBox" class="image-upload-box">
                                <div class="image-upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <div class="image-upload-text">
                                    Klik atau drag gambar ke sini
                                </div>
                                <div class="image-upload-hint">
                                    Format: JPG, PNG, GIF, WebP | Ukuran maksimal: 5MB
                                </div>
                            </div>
                            <input type="file" id="imageUploadInput" name="photo" class="image-upload-input" accept="image/*">
                        </div>

                        <div id="imageErrorMessage" class="image-upload-error"></div>
                        <div id="imageSuccessMessage" class="image-upload-success"></div>
                        <div id="imageLoadingMessage" class="image-upload-loading">
                            <div class="image-upload-loading-spinner"></div>
                            <p>Mengunggah gambar...</p>
                        </div>

                        <?php if ($is_edit && !empty($data['path_image'])): ?>
                            <div class="image-preview-container">
                                <img src="<?php echo BASE_URL . htmlspecialchars($data['path_image']); ?>" alt="Foto Karyawan">
                                <button type="button" class="image-preview-remove" id="removeImageBtn" title="Hapus gambar">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        <?php endif; ?>
                        <input type="hidden" name="existing_image" id="existingImage" value="<?php echo ($is_edit && !empty($data['path_image'])) ? '1' : '0'; ?>" />
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="aktif" name="aktif" value="1" <?php echo (isset($data['aktif']) && $data['aktif'] == 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="aktif">
                                <i class="fas fa-check-circle"></i> Status Aktif
                            </label>
                        </div>
                        <small class="text-muted d-block mt-2">Centang untuk mengaktifkan karyawan ini dalam sistem</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-title="Simpan data karyawan baru">
                            <i class="fas fa-save"></i> <?php echo $is_edit ? 'Update' : 'Simpan'; ?>
                        </button>
                        <a href="<?php echo BASE_URL; ?>views/karyawan.php" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-title="Kembali ke halaman sebelumnya">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Form Validation
    (function() {
        'use strict';
        const form = document.querySelector('.needs-validation');
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    })();

    // Initialize Tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Image Upload Functionality
        const imageUploadBox = document.getElementById('imageUploadBox');
        const imageUploadInput = document.getElementById('imageUploadInput');
        const imageErrorMessage = document.getElementById('imageErrorMessage');
        const imageSuccessMessage = document.getElementById('imageSuccessMessage');
        const imageLoadingMessage = document.getElementById('imageLoadingMessage');
        const removeImageBtn = document.getElementById('removeImageBtn');

        // File size and type validation
        const MAX_FILE_SIZE = 5242880; // 5MB
        const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        function clearMessages() {
            imageErrorMessage.classList.remove('active');
            imageSuccessMessage.classList.remove('active');
            imageErrorMessage.textContent = '';
            imageSuccessMessage.textContent = '';
        }

        function validateFile(file) {
            clearMessages();

            // Check file size
            if (file.size > MAX_FILE_SIZE) {
                imageErrorMessage.textContent = 'File terlalu besar. Maksimal 5MB.';
                imageErrorMessage.classList.add('active');
                return false;
            }

            // Check file type
            if (!ALLOWED_TYPES.includes(file.type)) {
                imageErrorMessage.textContent = 'Tipe file tidak diizinkan. Gunakan: JPG, PNG, GIF, WebP';
                imageErrorMessage.classList.add('active');
                return false;
            }

            // Check file extension
            const extension = file.name.split('.').pop().toLowerCase();
            if (!ALLOWED_EXTENSIONS.includes(extension)) {
                imageErrorMessage.textContent = 'Ekstensi file tidak valid.';
                imageErrorMessage.classList.add('active');
                return false;
            }

            return true;
        }

        function showPreview(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewContainer = document.querySelector('.image-preview-container');
                if (previewContainer) {
                    previewContainer.remove();
                }

                const newPreview = document.createElement('div');
                newPreview.className = 'image-preview-container';
                newPreview.innerHTML = `
                    <img src="${e.target.result}" alt="Preview">
                    <button type="button" class="image-preview-remove" id="newRemoveImageBtn" title="Hapus gambar">
                        <i class="fas fa-times"></i>
                    </button>
                `;

                const formGroupImage = document.querySelector('.form-group-image');
                const existingImage = document.getElementById('existingImage');
                if (existingImage) {
                    existingImage.parentNode.insertBefore(newPreview, existingImage);
                } else {
                    formGroupImage.appendChild(newPreview);
                }

                document.getElementById('newRemoveImageBtn').addEventListener('click', function(e) {
                    e.preventDefault();
                    newPreview.remove();
                    imageUploadInput.value = '';
                    clearMessages();
                });
            };
            reader.readAsDataURL(file);
        }

        // Click to upload
        imageUploadBox.addEventListener('click', function() {
            imageUploadInput.click();
        });

        // File input change
        imageUploadInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && validateFile(file)) {
                showPreview(file);
                imageSuccessMessage.textContent = 'Gambar berhasil dipilih: ' + file.name;
                imageSuccessMessage.classList.add('active');
            } else if (file) {
                imageUploadInput.value = '';
            }
        });

        // Drag and drop
        imageUploadBox.addEventListener('dragover', function(e) {
            e.preventDefault();
            imageUploadBox.classList.add('dragover');
        });

        imageUploadBox.addEventListener('dragleave', function() {
            imageUploadBox.classList.remove('dragover');
        });

        imageUploadBox.addEventListener('drop', function(e) {
            e.preventDefault();
            imageUploadBox.classList.remove('dragover');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                if (validateFile(file)) {
                    imageUploadInput.files = files;
                    showPreview(file);
                    imageSuccessMessage.textContent = 'Gambar berhasil dipilih: ' + file.name;
                    imageSuccessMessage.classList.add('active');
                } else {
                    imageUploadInput.files = new DataTransfer().items;
                }
            }
        });

        // Remove existing image button
        if (removeImageBtn) {
            removeImageBtn.addEventListener('click', function(e) {
                e.preventDefault();
                this.closest('.image-preview-container').remove();
                document.getElementById('existingImage').value = '0';
                clearMessages();
            });
        }
    });
</script>

<?php include __DIR__ . '/layout-footer.php'; ?>
