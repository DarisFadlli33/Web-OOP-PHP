FITUR TAMBAHAN - DOKUMENTASI

=== BREADCRUMB NAVIGATION ===

Lokasi: layout.php (baris 83-113)

Breadcrumb menunjukkan navigasi path pengguna di dalam aplikasi. Setiap halaman memiliki breadcrumb yang menunjukkan posisi saat ini dalam struktur navigasi.

Struktur Breadcrumb:
- Home: Link ke dashboard
- Section: Link ke halaman list (karyawan, jabatan, dll)
- Current: Halaman aktif (tidak bisa diklik)

Contoh pada halaman Daftar Karyawan:
Home / Daftar Karyawan

Implementasi:
Di setiap halaman list/form, tambahkan di PHP sebelum include layout.php:

$breadcrumb = [
    ['label' => 'Nama Halaman', 'icon' => 'icon-name']
];

Icon menggunakan Font Awesome. Contoh icon:
- users: untuk karyawan
- briefcase: untuk jabatan
- star: untuk rating
- clock: untuk lembur
- money-bill: untuk gaji

File yang sudah diperbaiki:
- karyawan.php
- jabatan.php
- rating.php
- lembur.php
- gaji.php
- index.php (dashboard - breadcrumb kosong)

Styling CSS: .breadcrumb-nav di assets/css/style.css


=== DELETE CONFIRMATION MODAL ===

Lokasi: layout-footer.php (baris 5-29)

Modal konfirmasi penghapusan adalah dialog yang muncul sebelum user menghapus data. Memastikan data tidak terhapus secara tidak sengaja.

Fitur Modal:
- Icon warning besar
- Pesan konfirmasi
- Nama data yang akan dihapus
- Tombol Batal dan Hapus
- Styling dengan warna merah (danger)

Implementasi:
Ganti delete button dari tag <a> menjadi <button> dengan onclick:

<button class="btn btn-danger btn-sm"
        onclick="showDeleteConfirm('url', 'item-name');"
        title="Hapus">
    <i class="fas fa-trash"></i>
</button>

Contoh penggunaan:
onclick="showDeleteConfirm('<?php echo BASE_URL; ?>controllers/karyawan-controller.php?action=delete&id=<?php echo $item['id']; ?>', '<?php echo addslashes($item['nama']); ?>');"

JavaScript Handler:
- showDeleteConfirm(url, itemName): Function untuk menampilkan modal
- Modal akan menyimpan URL dan redirect jika user konfirmasi

File yang sudah diperbaiki:
- karyawan.php
- jabatan.php
- rating.php
- lembur.php
- gaji.php

Styling CSS: .delete-modal-* di assets/css/style.css


=== PENGGUNAAN ===

Breadcrumb:
1. Definisikan array di halaman (<$breadcrumb>)
2. Layout.php otomatis menampilkan jika breadcrumb tidak kosong
3. Responsive dan mobile-friendly

Delete Confirmation:
1. Ubah delete link menjadi button
2. Tambahkan onclick="showDeleteConfirm(url, name)"
3. Modal muncul otomatis pada saat click
4. User pilih Batal atau Hapus
5. Jika Hapus, redirect ke delete action

Kedua fitur fully integrated dengan Bootstrap 5.3.0 dan custom styling.

=== FORM VALIDATION STYLING ===

Lokasi: karyawan-form.php, Bootstrap validation classes di assets/css/style.css

Form validation menampilkan feedback visual saat user mengisi form - error icon dan pesan untuk field yang belum valid.

Fitur Validation:
- Icon error/success pada field
- Pesan feedback berwarna merah/hijau
- Validasi saat form submit
- Field yang wajib diisi ditandai dengan (*)
- Field dengan min/max constraints dipastikan

Implementasi:
1. Tambahkan class "needs-validation" pada form
2. Tambahkan "required" pada input yang wajib
3. Tambahkan invalid-feedback div untuk pesan error

Contoh:
```html
<form class="needs-validation" novalidate>
    <input type="text" class="form-control" name="nama" required>
    <div class="invalid-feedback">
        Nama harus diisi
    </div>
</form>
```

JavaScript validation di karyawan-form.php:
- checkValidity(): Cek apakah form valid
- was-validated: Class yang ditambahkan untuk show errors
- novalidate: Prevent browser default validation

Styling CSS: .form-control:invalid, .invalid-feedback, dll di assets/css/style.css

File yang sudah diperbaiki:
- karyawan-form.php

=== TOOLTIP ===

Lokasi: karyawan-form.php buttons, Bootstrap Bootstrap Tooltip

Tooltip menampilkan deskripsi singkat saat user hover pada button atau element.

Fitur Tooltip:
- Deskripsi satu baris saat hover
- Auto position (top/bottom/left/right)
- Disappear saat mouse leave
- Styling dengan warna primary

Implementasi:
Tambahkan data-bs-toggle="tooltip" dan data-bs-title ke element:

```html
<button class="btn btn-primary"
        data-bs-toggle="tooltip"
        data-bs-title="Simpan data karyawan baru">
    <i class="fas fa-save"></i> Simpan
</button>
```

JavaScript untuk initialize tooltips:
```javascript
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
tooltipTriggerList.forEach(el => {
    new bootstrap.Tooltip(el);
});
```

Styling CSS: .tooltip-inner, .bs-tooltip-* di assets/css/style.css

File yang sudah diperbaiki:
- karyawan-form.php (buttons)

=== TOAST NOTIFICATIONS ===

Lokasi: layout-footer.php (baris 56-94)

Toast notifications menggantikan alert biasa - muncul di corner dengan styling lebih baik dan auto-dismiss.

Fitur Toast:
- Muncul di top-right corner
- 4 tipe: success (hijau), danger (merah), warning (kuning), info (biru)
- Icon dan title otomatis sesuai tipe
- Auto-dismiss setelah beberapa detik
- User bisa close manual

Implementasi:
Gunakan function showToast(message, type, title):

```javascript
showToast('Data berhasil disimpan', 'success');
showToast('Terjadi kesalahan', 'danger', 'Error');
showToast('Data akan dihapus', 'warning');
```

Atau menggunakan SESSION PHP otomatis menampilkan toast:
```php
$_SESSION['success'] = 'Data berhasil ditambahkan';
$_SESSION['error'] = 'Gagal menambahkan data';
$_SESSION['warning'] = 'Peringatan penting';
```

Toast container disembunyikan di layout-footer.php
JavaScript otomatis show session notify sebagai toast

Styling CSS: .toast-container, .toast, .toast-success, dll di assets/css/style.css

File yang sudah diperbaiki:
- layout-footer.php (container + handler)

=== PAGINATION ===

Lokasi: karyawan.php (list page example)

Pagination membagi data panjang ke halaman-halaman untuk performa lebih baik dan UX yang cleaner.

Fitur Pagination:
- Tombol Awal, Sebelumnya, nomor halaman, Berikutnya, Akhir
- Link yang relevan saja ditampilkan (smart pagination)
- Info counter: "Menampilkan X hingga Y dari Z data"
- Page number highlight untuk halaman aktif
- Responsive pada mobile

Implementasi:
```php
$items_per_page = 10;
$current_page_num = isset($_GET['page']) ? max(1, $_GET['page']) : 1;
$offset = ($current_page_num - 1) * $items_per_page;

$total_items = count($data);
$total_pages = ceil($total_items / $items_per_page);
$paginated_data = array_slice($data, $offset, $items_per_page);
```

Kemudian loop $paginated_data daripada $data

Pagination links di footer tabel dengan Bootstrap pagination component

Styling CSS: .pagination, .page-link, .page-item, dll di assets/css/style.css

File yang sudah diperbaiki:
- karyawan.php (10 items per page dengan pagination controls)

=== PENGGUNAAN SEMUA FITUR ===

Form Validation:
1. Tambahkan class "needs-validation" pada form
2. Tambahkan required pada field wajib
3. Tambahkan invalid-feedback messages
4. JavaScript auto-handle validation on submit

Tooltip:
1. Tambahkan data-bs-toggle="tooltip" dan data-bs-title
2. JavaScript auto-initialize di DOMContentLoaded

Toast:
1. Gunakan showToast() function di JavaScript
2. Atau set $_SESSION['success']/['error'] di PHP
3. Toast auto-show on page load

Pagination:
1. Hitung total_pages dan offset dari data
2. Gunakan array_slice untuk paginate
3. Generate pagination links di template

Semua fitur fully integrated dengan Bootstrap 5.3.0 dan custom styling.

=== DROPDOWN MENU ===

Lokasi: layout.php (topbar-right), assets/css/style.css

Dropdown menu menyediakan quick access ke halaman-halaman penting dan fitur tambahan. Terletak di topbar sebelah jam.

Fitur Dropdown:
- Button Menu dengan dropdown toggle
- Multi sections dengan divider
- Icon pada setiap menu item
- Hover effect dengan left border animation
- Responsive positioning

Implementasi:
```html
<div class="dropdown">
    <button class="dropdown-toggle" data-bs-toggle="dropdown">Menu</button>
    <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="url"><i class="fas fa-icon"></i> Label</a></li>
        <li><hr class="dropdown-divider"></li>
    </ul>
</div>
```

File yang sudah diperbaiki:
- layout.php (topbar menu)

Styling CSS: .dropdown-menu, .dropdown-item, .dropdown-divider di assets/css/style.css


=== ACCORDION ===

Lokasi: karyawan-detail.php, assets/css/style.css

Accordion mengelompokkan informasi detail karyawan ke dalam sections yang collapsible. User bisa expand/collapse sesuai kebutuhan.

Fitur Accordion:
- 3 sections: Informasi Personal, Pekerjaan, Gaji & Tunjangan
- First section expanded by default, others collapsed
- Icon pada setiap section header
- Smooth collapse/expand animation
- Info alert di footer untuk total kompensasi

Implementasi:
```html
<div class="accordion" id="mainAccordion">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseId">
                Judul Section
            </button>
        </h2>
        <div id="collapseId" class="accordion-collapse collapse show" data-bs-parent="#mainAccordion">
            <div class="accordion-body">
                Content di sini
            </div>
        </div>
    </div>
</div>
```

File yang sudah diperbaiki:
- karyawan-detail.php (3 accordion sections)

Styling CSS: .accordion, .accordion-item, .accordion-button, .accordion-body di assets/css/style.css


=== BOOTSTRAP SWITCHES (FORM TOGGLE) ===

Lokasi: views/karyawan-form.php, assets/css/style.css

Switch adalah toggle checkbox dengan styling modern untuk input boolean. User bisa tap/click untuk on/off state.

Fitur Switch:
- Toggle on/off dengan visual feedback
- Smooth animation saat switch
- Green color untuk active, gray untuk inactive
- Checkbox standard HTML dengan custom styling

Implementasi:
```html
<div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" id="aktif" name="aktif" value="1" checked>
    <label class="form-check-label" for="aktif">
        <i class="fas fa-check-circle"></i> Status Aktif
    </label>
</div>
```

File yang sudah diperbaiki:
- karyawan-form.php (switch untuk Status Aktif)

Styling CSS: .form-check-input, .form-check-label di assets/css/style.css


=== CUSTOM CHECKBOXES (MULTI-SELECT) ===

Lokasi: views/karyawan.php, assets/css/style.css

Custom checkboxes memungkinkan user memilih multiple row di table untuk bulk operations. Includes select-all checkbox dan bulk delete button.

Fitur Custom Checkbox:
- Checkbox pada setiap row
- Select-all checkbox di table header
- Bulk delete button yang muncul hanya saat ada yang dipilih
- Counter berapa item dipilih
- Styling dengan border dan hover effects

Implementasi:
```html
<th style="width: 40px;">
    <input type="checkbox" class="form-check-input" id="selectAllCheckbox" onchange="toggleSelectAll(this);">
</th>
<td>
    <input type="checkbox" class="form-check-input row-checkbox" value="<?php echo $item['id']; ?>" onchange="updateBulkDeleteBtn();">
</td>
```

JavaScript Handler:
- toggleSelectAll(): Select/deselect semua checkbox
- updateBulkDeleteBtn(): Show/hide bulk delete button based on selection
- bulkDelete(): Collect selected IDs dan trigger delete confirmation

File yang sudah diperbaiki:
- karyawan.php (checkbox column + bulk delete functionality)

Styling CSS: .form-check-input di table, table .form-check-input:checked di assets/css/style.css


=== CAROUSEL ===

Lokasi: index.php (dashboard), assets/css/style.css

Carousel adalah slideshow yang menampilkan karyawan terbaru dengan auto-rotation, navigation controls, dan fade effect.

Fitur Carousel:
- Auto-rotate setiap employee
- Fade transition effect
- Indicator dots untuk jump ke slide
- Previous/next buttons untuk manual navigation
- Employee info display (foto, nama, divisi, jabatan, rating, tanggal bergabung)

Implementasi:
```html
<div id="employeeCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php foreach ($recent_karyawan as $idx => $emp): ?>
            <button type="button" data-bs-target="#employeeCarousel" data-bs-slide-to="<?php echo $idx; ?>" [...] ></button>
        <?php endforeach; ?>
    </div>
    <div class="carousel-inner">
        <?php foreach ($recent_karyawan as $idx => $emp): ?>
            <div class="carousel-item <?php echo $idx === 0 ? 'active' : ''; ?>">
                <!-- Employee content -->
            </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#employeeCarousel" data-bs-slide="prev"></button>
    <button class="carousel-control-next" type="button" data-bs-target="#employeeCarousel" data-bs-slide="next"></button>
</div>
```

File yang sudah diperbaiki:
- index.php (carousel di dashboard)

Styling CSS: .carousel, .carousel-item, .carousel-indicators, .carousel-fade di assets/css/style.css


=== NAV TABS ===

Lokasi: views/karyawan-detail.php, assets/css/style.css

Nav tabs adalah tab-based navigation untuk organize content ke multiple sections yang bisa di-click untuk switch view.

Fitur Nav Tabs:
- 3 tabs: Personal, Pekerjaan, Salary
- Click tab untuk show/hide content
- Active tab highlighting dengan bottom border dan color
- Icon pada setiap tab
- Fade transition saat switch tab

Implementasi:
```html
<ul class="nav nav-tabs mb-4" id="detailTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal-content" [...] >
            <i class="fas fa-user-tag"></i> Informasi Personal
        </button>
    </li>
    <!-- More tabs... -->
</ul>

<div class="tab-content" id="detailTabContent">
    <div class="tab-pane fade show active" id="personal-content" [...] >
        <!-- Tab content -->
    </div>
    <!-- More tab panes... -->
</div>
```

File yang sudah diperbaiki:
- karyawan-detail.php (nav tabs untuk detail sections)

Styling CSS: .nav-tabs, .nav-link, .tab-pane di assets/css/style.css


=== PENGGUNAAN FITUR TAMBAHAN ===

Dropdown Menu:
1. Letakkan di area topbar atau header
2. Gunakan data-bs-toggle="dropdown" pada button
3. Atur positioning dengan dropdown-menu-end (kanan) atau dropdown-menu (kiri)
4. Tambahkan icon pada setiap item

Accordion:
1. Buat div dengan class "accordion" dan unique id
2. Setiap item punya accordion-item wrapper
3. Button punya data-bs-target="#idTarget" sesuai section
4. data-bs-parent="#accordionId" untuk mutually exclusive expand

Bootstrap Switches:
1. Wrap dengan div class "form-check form-switch"
2. Checkbox dengan class "form-check-input"
3. Label dengan class "form-check-label"

Custom Checkboxes:
1. Gunakan class "form-check-input" pada checkbox di table
2. JavaScript handler untuk select-all dan bulk operations
3. Update button visibility based on selection

Carousel:
1. Parent div dengan class "carousel slide carousel-fade"
2. Indicators div dengan carousel-indicators
3. Inner div dengan carousel-inner dan carousel-items
4. Navigation buttons dengan carousel-control-prev/next

Nav Tabs:
1. UL dengan class "nav nav-tabs" dan role="tablist"
2. Buttons dengan data-bs-toggle="tab" dan data-bs-target
3. Tab panes dengan class "tab-pane fade"
4. Set active class pada first tab dan tab-pane

Semua fitur fully integrated dengan Bootstrap 5.3.0 dan custom styling.

