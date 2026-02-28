            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header delete-modal-header">
                    <h5 class="modal-title" id="deleteConfirmLabel">
                        <i class="fas fa-exclamation-triangle"></i> Konfirmasi Penghapusan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body delete-modal-body">
                    <i class="fas fa-trash-alt"></i>
                    <p><strong>Apakah Anda yakin ingin menghapus data ini?</strong></p>
                    <p id="deleteItemName"></p>
                    <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer delete-modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>

    <script>
        // Delete Confirmation Modal Handler
        let deleteUrl = '';
        const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'), {});
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        window.showDeleteConfirm = function(url, itemName = '') {
            deleteUrl = url;
            document.getElementById('deleteItemName').textContent = itemName ? '(' + itemName + ')' : '';
            deleteConfirmModal.show();
        };

        confirmDeleteBtn.addEventListener('click', function() {
            if (deleteUrl) {
                window.location.href = deleteUrl;
            }
        });

        // Toast Notification Helper
        window.showToast = function(message, type = 'info', title = '') {
            const container = document.getElementById('toastContainer');
            const toastId = 'toast-' + Date.now();

            const titles = {
                'success': 'Sukses',
                'danger': 'Gagal',
                'warning': 'Peringatan',
                'info': 'Informasi'
            };

            const toastHtml = `
                <div id="${toastId}" class="toast toast-${type}" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">
                            ${type === 'success' ? '<i class="fas fa-check-circle"></i>' : ''}
                            ${type === 'danger' ? '<i class="fas fa-exclamation-circle"></i>' : ''}
                            ${type === 'warning' ? '<i class="fas fa-exclamation-triangle"></i>' : ''}
                            ${type === 'info' ? '<i class="fas fa-info-circle"></i>' : ''}
                            ${title || titles[type]}
                        </strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', toastHtml);
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement);
            toast.show();

            toastElement.addEventListener('hidden.bs.toast', function() {
                toastElement.remove();
            });
        };

        // Show toast notifications from session
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (isset($_SESSION['success'])): ?>
                showToast('<?php echo addslashes($_SESSION['success']); ?>', 'success');
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                showToast('<?php echo addslashes($_SESSION['error']); ?>', 'danger');
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['warning'])): ?>
                showToast('<?php echo addslashes($_SESSION['warning']); ?>', 'warning');
                <?php unset($_SESSION['warning']); ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>
