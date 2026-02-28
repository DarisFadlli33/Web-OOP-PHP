<?php
/**
 * FileUploadHandler - Utility class untuk menangani upload file dengan validasi keamanan
 *
 * Features:
 * - File type validation (image only)
 * - File size validation
 * - Safe filename generation
 * - Directory management
 * - Error handling
 *
 * Usage:
 * $handler = new FileUploadHandler('path/to/directory');
 * $result = $handler->upload('fieldname');
 * if ($result['success']) {
 *     echo "File: " . $result['filename'];
 * } else {
 *     echo "Error: " . $result['error'];
 * }
 */

class FileUploadHandler {

    private $upload_dir;
    private $max_file_size = 5242880; // 5MB in bytes
    private $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    private $allowed_mimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    /**
     * Constructor
     * @param string $upload_directory Path to upload directory
     */
    public function __construct($upload_directory) {
        $this->upload_dir = $upload_directory;

        // Create directory if it doesn't exist
        if (!is_dir($this->upload_dir)) {
            @mkdir($this->upload_dir, 0755, true);
        }
    }

    /**
     * Generate safe filename
     * @param string $original_filename Original filename from upload
     * @return string Safe filename
     */
    private function generateSafeFilename($original_filename) {
        $pathinfo = pathinfo($original_filename);
        $extension = strtolower($pathinfo['extension']);
        $filename = $pathinfo['filename'];

        // Remove non-alphanumeric characters
        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '', $filename);

        // Add timestamp to ensure uniqueness
        $timestamp = time();
        $random = rand(1000, 9999);

        return "{$filename}_{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Get file extension
     * @param string $filename Filename to check
     * @return string|false Extension or false
     */
    private function getFileExtension($filename) {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return (in_array($ext, $this->allowed_extensions)) ? $ext : false;
    }

    /**
     * Get MIME type of uploaded file
     * @param string $file_path Path to file
     * @return string MIME type
     */
    private function getMimeType($file_path) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file_path);
        finfo_close($finfo);
        return $mime;
    }

    /**
     * Validate file
     * @param array $file File from $_FILES
     * @return array Validation result with 'valid' and 'error' keys
     */
    private function validateFile($file) {
        $result = ['valid' => true, 'error' => ''];

        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors = [
                UPLOAD_ERR_INI_SIZE => 'File terlalu besar (exceeds max size)',
                UPLOAD_ERR_FORM_SIZE => 'File terlalu besar (exceeds form max size)',
                UPLOAD_ERR_PARTIAL => 'Upload file tidak lengkap',
                UPLOAD_ERR_NO_FILE => 'Tidak ada file yang diupload',
                UPLOAD_ERR_NO_TMP_DIR => 'Direktori temp tidak ditemukan',
                UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke disk',
                UPLOAD_ERR_EXTENSION => 'Upload dihentikan oleh extension'
            ];
            $result['valid'] = false;
            $result['error'] = $errors[$file['error']] ?? 'Upload error tidak dikenal';
            return $result;
        }

        // Check file size
        if ($file['size'] > $this->max_file_size) {
            $result['valid'] = false;
            $result['error'] = 'File terlalu besar. Maksimal 5MB.';
            return $result;
        }

        // Check if file is empty
        if ($file['size'] == 0) {
            $result['valid'] = false;
            $result['error'] = 'File kosong.';
            return $result;
        }

        // Check file extension
        if (!$this->getFileExtension($file['name'])) {
            $result['valid'] = false;
            $result['error'] = 'Tipe file tidak diizinkan. Gunakan: JPG, PNG, GIF, WebP';
            return $result;
        }

        // Check MIME type
        $mime = $this->getMimeType($file['tmp_name']);
        if (!in_array($mime, $this->allowed_mimes)) {
            $result['valid'] = false;
            $result['error'] = 'Tipe MIME file tidak valid.';
            return $result;
        }

        // Additional image validation using getimagesize
        if (@getimagesize($file['tmp_name']) === false) {
            $result['valid'] = false;
            $result['error'] = 'File bukan gambar valid.';
            return $result;
        }

        return $result;
    }

    /**
     * Upload file dari $_FILES
     * @param string $field_name Field name dari HTML form
     * @return array Result dengan keys: 'success', 'filename', 'filepath', 'error'
     */
    public function upload($field_name) {
        $result = [
            'success' => false,
            'filename' => '',
            'filepath' => '',
            'error' => ''
        ];

        // Check if field exists
        if (!isset($_FILES[$field_name])) {
            $result['error'] = 'Field tidak ditemukan.';
            return $result;
        }

        $file = $_FILES[$field_name];

        // Validate file
        $validation = $this->validateFile($file);
        if (!$validation['valid']) {
            $result['error'] = $validation['error'];
            return $result;
        }

        // Generate safe filename
        $safe_filename = $this->generateSafeFilename($file['name']);
        $target_path = $this->upload_dir . DIRECTORY_SEPARATOR . $safe_filename;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            chmod($target_path, 0644); // Set file permissions

            $result['success'] = true;
            $result['filename'] = $safe_filename;
            $result['filepath'] = str_replace('\\', '/', $target_path); // Normalize path

            return $result;
        } else {
            $result['error'] = 'Gagal memindahkan file ke direktori tujuan.';
            return $result;
        }
    }

    /**
     * Delete file
     * @param string $filepath Path to file
     * @return bool Success or failure
     */
    public function delete($filepath) {
        if (file_exists($filepath)) {
            return @unlink($filepath);
        }
        return false;
    }

    /**
     * Get file URL relative to web root
     * @param string $filename Filename
     * @return string Relative URL
     */
    public function getFileUrl($filename) {
        $base_url = 'http://localhost/Database-PHP/'; // Should be dynamically determined
        $relative_path = str_replace('\\', '/', str_replace($_SERVER['DOCUMENT_ROOT'], '', $this->upload_dir));
        return $base_url . trim($relative_path, '/') . '/' . $filename;
    }

    /**
     * Set max file size
     * @param int $size Size in bytes
     */
    public function setMaxFileSize($size) {
        $this->max_file_size = $size;
    }

    /**
     * Set allowed extensions
     * @param array $extensions Array of allowed extensions
     */
    public function setAllowedExtensions($extensions) {
        $this->allowed_extensions = array_map('strtolower', $extensions);
    }

    /**
     * Get current upload directory
     * @return string Upload directory path
     */
    public function getUploadDir() {
        return $this->upload_dir;
    }
}
?>
