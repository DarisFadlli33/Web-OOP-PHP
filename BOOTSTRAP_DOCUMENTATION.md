# BOOTSTRAP USAGE DOCUMENTATION
## Sistem Manajemen Karyawan - HRM

---

## 1️⃣ BOOTSTRAP CDN YANG DIGUNAKAN

### Di layout.php (Header)
```html
<!-- Bootstrap CSS 5.3.0 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome Icons 6.4.0 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Custom CSS -->
<link rel="stylesheet" href="assets/css/style.css">
```

### Di layout-footer.php (Footer)
```html
<!-- Bootstrap JS 5.3.0 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery 3.7.0 (Optional) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/main.js"></script>
```

---

## 2️⃣ PENGGUNAAN BOOTSTRAP PER FILE

### A. LAYOUT & TEMPLATE

#### layout.php ✓ OPTIMAL
```
Penggunaan:
- Alert Components (alert, alert-success, alert-danger, alert-warning)
- Close Button (btn-close)
- Icon Integration (Font Awesome)
- Custom CSS untuk layout, Bootstrap untuk components
```

---

### B. DASHBOARD & LIST PAGES

#### index.php (Dashboard) ✓ OPTIMAL
```
Grid System:
- Row layout untuk 4 statistik cards
<div class="row mb-4">
  <div class="col-md-6 col-lg-3">...</div>  <!-- 2 cols pada md, 4 cols pada lg -->
  <div class="col-md-6 col-lg-3">...</div>
  <div class="col-md-6 col-lg-3">...</div>
  <div class="col-md-6 col-lg-3">...</div>
</div>

Components:
- Card dengan card-body untuk statistik
- Table dengan table-hover dan table-responsive
- Badge untuk rating display
- Button dengan varian (btn-primary, btn-info, btn-light)
- Alert untuk success/error messages

Responsive:
- Mobile: 2 cards per row (col-md-6)
- Desktop: 4 cards per row (col-lg-3)
```

#### karyawan.php ✓ OPTIMAL
```
Components:
- Card wrapper (card, card-header, card-body)
- Table-responsive container
- Table dengan thead (table-dark) dan tbody (table-hover)
- Button group (btn-info, btn-warning, btn-danger, btn-sm)
- Badge untuk rating

Classes:
- d-flex, justify-content-between untuk header
- action-buttons untuk button grouping
- table-responsive untuk horizontal scroll
```

#### jabatan.php, rating.php, lembur.php, gaji.php ✓ OPTIMAL
```
Pattern Sama dengan karyawan.php:
- Card layout
- Table dengan responsive wrapper
- Button actions
- Badge untuk status/info
```

---

### C. FORM PAGES

#### karyawan-form.php ✓ OPTIMAL
```
Grid System:
<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">...</div>
      <div class="card-body">
        <!-- Form content -->
      </div>
    </div>
  </div>
</div>

Form Fields (2 Columns):
<div class="row mb-3">
  <div class="col-md-6">
    <label class="form-label" for="nama">Nama *</label>
    <input type="text" class="form-control" id="nama" name="nama" required>
  </div>
  <div class="col-md-6">
    <label class="form-label" for="umur">Umur</label>
    <input type="number" class="form-control" id="umur" name="umur">
  </div>
</div>

Components:
- card + card-header + card-body
- form-label + form-control
- row + col-md-6 untuk 2-column layout
- col-lg-8 untuk form container width
- d-flex + gap-2 untuk button group
- btn-primary, btn-secondary

Classes:
- mb-3 (margin-bottom untuk spacing antar field)
- form-label (styling label)
- form-control (styling input, select, textarea)
```

#### jabatan-form.php, rating-form.php, lembur-form.php ✓ OPTIMAL
```
Pattern Sama dengan rincian di atas
Perbedaan:
- col-lg-6 untuk form lebih narrow (optional fields)
- alert-info untuk preview/info message
```

#### gaji-form.php ✓ OPTIMAL (COMPLEX)
```
Nested Grid:
<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <!-- Form fields -->
    </div>
    <div class="card mt-4 mb-4">
      <div class="card-header bg-primary">
        <!-- Rincian Gaji Header -->
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-6">...</div>
          <div class="col-md-6">...</div>
        </div>
      </div>
    </div>
  </div>
</div>

Components:
- Nested cards untuk rincian kompleks
- Text utilities (text-success, text-muted, text-primary)
- Color classes untuk highlight (text-success untuk total)
```

---

### D. DETAIL PAGES

#### karyawan-detail.php ✓ OPTIMAL
```
Grid System:
<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <!-- Title dan buttons -->
        </div>
      </div>
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-md-6">...</div>
          <div class="col-md-6">...</div>
        </div>
      </div>
    </div>
  </div>
</div>

Components:
- card + card-header (dengan d-flex untuk title + buttons)
- row + col-md-6 untuk 2-column display
- Badge untuk rating
- Button untuk edit/back (btn-warning, btn-secondary)
- Color utilities (text-muted untuk secondary info)
```

#### jabatan-detail.php, rating-detail.php, lembur-detail.php, gaji-detail.php ✓ OPTIMAL
```
Pattern Sama dengan rincian di atas
Dengan styling khusus:
- Text color utilities (text-success, text-info, text-primary)
- Nested cards untuk complex data (gaji)
- Badge dengan warna sesuai status
```

---

## 3️⃣ BOOTSTRAP COMPONENTS SUMMARY

### Grid System
```
Breakpoints:
- xs (< 576px)     : col-12 (full width)
- sm (≥ 576px)     : col-sm-*
- md (≥ 768px)     : col-md-6, col-md-8 (used here)
- lg (≥ 992px)     : col-lg-3, col-lg-6, col-lg-8 (used here)
- xl (≥ 1200px)    : col-xl-*
- xxl (≥ 1400px)   : col-xxl-*

Penggunaan di Project:
- col-md-6  : 2-column layout di tablet+ (form fields, detail pages)
- col-lg-3  : 4-column layout di desktop (dashboard cards)
- col-lg-6  : 2-column layout di desktop (narrow forms)
- col-lg-8  : Single column wide form
```

### Cards
```
Structure:
<div class="card">
  <div class="card-header">Header Content</div>
  <div class="card-body">Body Content</div>
</div>

Penggunaan:
- Wrapper untuk form, detail pages, list pages
- card-header untuk title/label
- card-body untuk content
```

### Tables
```
Structure:
<div class="table-responsive">
  <table class="table table-hover">
    <thead class="table-dark">
      <tr>
        <th>Column</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Data</td>
      </tr>
    </tbody>
  </table>
</div>

Classes:
- table-responsive : Horizontal scroll pada small screens
- table-hover      : Highlight row on hover
- table-dark       : Dark header styling
- table-sm         : Compact table
```

### Buttons
```
Variants:
- btn-primary   : Main action (Tambah, Simpan, Update)
- btn-secondary : Secondary action (Kembali, Cancel)
- btn-info      : Info action (Detail, View)
- btn-warning   : Warning action (Edit, Modify)
- btn-danger    : Destructive action (Hapus, Delete)
- btn-light     : Light alternative

Sizes:
- btn-sm  : Small buttons (dalam table action)
- (default) : Normal size

Group:
- d-flex + gap-2 : Space buttons dengan gap

Example:
<div class="d-flex gap-2">
  <button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> Simpan
  </button>
  <a href="#" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
</div>
```

### Badges
```
Usage:
<span class="badge bg-warning text-dark">
  <i class="fas fa-star"></i> 5/5
</span>

Colors:
- badge-warning (bg-warning + text-dark)
- badge-success (bg-success + text-white)
- badge-danger (bg-danger + text-white)
- badge-primary (bg-primary + text-white)
```

### Alerts
```
Structure:
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <i class="fas fa-check-circle"></i> Message text
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

Types:
- alert-success  : Operasi berhasil
- alert-danger   : Error/gagal
- alert-warning  : Warning/peringatan
- alert-info     : Information

Classes:
- alert-dismissible : Tombol close
- fade show         : Animation
```

### Forms
```
Structure:
<div class="mb-3">
  <label class="form-label" for="input">Label *</label>
  <input type="text" class="form-control" id="input" name="input" required>
</div>

Classes:
- form-label    : Styling label
- form-control  : Styling input, select, textarea
- mb-3          : Margin bottom spacing

Validation (Optional):
<input class="form-control is-valid">
<input class="form-control is-invalid">
<div class="valid-feedback">Looks good!</div>
<div class="invalid-feedback">Please fix this.</div>
```

---

## 4️⃣ UTILITY CLASSES YANG DIGUNAKAN

### Flexbox
```
- d-flex              : Display flex
- justify-content-between : Space between items
- justify-content-center  : Center items
- align-items-center  : Vertical center
- align-items-start   : Align to start
- gap-2               : Gap between items (spacing)
- flex-direction-column : Column direction
- flex: 1             : Grow to fill
```

### Spacing
```
- mb-0, mb-3, mb-4    : Margin bottom
- mt-3, mt-4          : Margin top
- p-top, p-bottom     : Padding
- gap-2, gap-3        : Gap dalam flexbox
```

### Text Utilities
```
- text-muted    : Gray text (secondary info)
- text-success  : Green text (positive)
- text-danger   : Red text (negative)
- text-warning  : Yellow text (warning)
- text-info     : Blue text (information)
- text-primary  : Primary color
- text-dark     : Dark text
- text-white    : White text
```

### Display & Visibility
```
- d-flex          : Display flex
- w-100           : Width 100%
- h-100           : Height 100%
- overflow-hidden : Hide overflow
- text-overflow-ellipsis : Ellipsis for long text
```

---

## 5️⃣ RESPONSIVE DESIGN WITH BOOTSTRAP

### Breakpoint Strategy
```
Mobile First Approach:
1. Base styling untuk mobile (xs)
2. Adjust untuk sm (> 576px)
3. Adjust untuk md (> 768px) - col-md-6 untuk 2 columns
4. Adjust untuk lg (> 992px) - col-lg-3 untuk 4 columns

Grid Usage:
- Mobile: Full width (col-12)
- Tablet (md): 2 columns (col-md-6)
- Desktop (lg): 3-4 columns (col-lg-3, col-lg-4)
```

### Media Query Interaction
```
Bootstrap Breakpoint:
- Controlled oleh Bootstrap media queries
- Kombinasi dengan custom CSS media queries di style.css

Example (Dashboard 4 columns):
- < 768px (mobile): 1 column (full width)
- 768-991px (md):   2 columns (col-md-6)
- 992px+ (lg):      4 columns (col-lg-3)
```

---

## 6️⃣ PENGGUNAAN BOOTSTRAP DI SETIAP HALAMAN

### Dashboard (index.php)
```
Component:
✓ Grid 4 columns responsive (col-md-6 col-lg-3)
✓ Cards untuk statistik
✓ Table dengan responsive wrapper
✓ Badges untuk rating
✓ Buttons dengan varian
✓ Flexbox untuk alignment
```

### List Pages (karyawan, jabatan, rating, lembur, gaji)
```
Components:
✓ Card wrapper
✓ Table responsive
✓ Table-dark header
✓ Table-hover untuk interactivity
✓ Button group (info, warning, danger, sm)
✓ Badge untuk status
✓ Flexbox header dengan justify-content-between
```

### Form Pages (karyawan-form, jabatan-form, etc)
```
Components:
✓ Grid layout (col-lg-8, col-lg-6)
✓ Card struktur
✓ Form-label + form-control
✓ Row/col untuk multi-column inputs
✓ mb-3 untuk spacing
✓ Alert-info untuk preview/info
✓ Button group dengan gap-2
✓ Flexbox untuk button layout
```

### Detail Pages (karyawan-detail, jabatan-detail, etc)
```
Components:
✓ Grid layout (col-lg-8, col-lg-6)
✓ Card dengan responsive header
✓ Row/col untuk 2-column display
✓ d-flex justify-content-between untuk header
✓ Badge untuk rating/status
✓ Text utilities untuk styling
✓ Nested cards untuk complex data
```

---

## 7️⃣ BEST PRACTICES YANG DIIMPLEMENTASIKAN

### 1. Consistent Naming
```
✓ Menggunakan Bootstrap class names
✓ Kombinasi dengan custom classes (action-buttons, dashboard-card)
✓ Semantic HTML structure
```

### 2. Responsive Design
```
✓ Mobile-first approach
✓ Proper breakpoints (md, lg)
✓ Flexible grid system
✓ Responsive utilities
```

### 3. Component Reusability
```
✓ Card pattern untuk semua halaman
✓ Table pattern konsisten
✓ Button pattern sama
✓ Form pattern terstandarisasi
```

### 4. Accessibility
```
✓ Proper label associations
✓ Button dengan icon + text
✓ Alert dengan role="alert"
✓ Semantic HTML tags
```

### 5. Performance
```
✓ Bootstrap CDN (minimal caching)
✓ Custom CSS terpisah
✓ No duplicate classes
✓ Efficient CSS selectors
```

---

## 8️⃣ REKOMENDASI ENHANCEMENT (Optional)

### A. Form Validation Styling
```
Tidak diimplementasikan: is-valid, is-invalid

Bisa ditambah:
<input class="form-control is-invalid">
<div class="invalid-feedback">Error message</div>

<input class="form-control is-valid">
<div class="valid-feedback">Looks good!</div>
```

### B. Modal untuk Confirm Dialog
```
Tidak diimplementasikan: Modal component

Bisa ditambah:
<div class="modal fade" id="confirmModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi</h5>
      </div>
      <div class="modal-body">Yakin hapus data?</div>
      <div class="modal-footer">
        <button class="btn btn-danger">Hapus</button>
      </div>
    </div>
  </div>
</div>
```

### C. Breadcrumb Navigation
```
Tidak diimplementasikan: Breadcrumb

Bisa ditambah di detail pages:
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Detail</li>
  </ol>
</nav>
```

### D. Pagination
```
Tidak diimplementasikan: Pagination

Bisa ditambah untuk table besar:
<nav aria-label="Page navigation">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item active"><span class="page-link">2</span></li>
    <li class="page-item"><a class="page-link" href="#">Next</a></li>
  </ul>
</nav>
```

### E. Tooltip & Popover
```
Tidak diimplementasikan: Tooltip/Popover

Bisa ditambah:
<button class="btn btn-sm" data-bs-toggle="tooltip"
        title="Delete this record">
  <i class="fas fa-trash"></i>
</button>

JavaScript:
const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
```

### F. Toast Notifications
```
Tidak diimplementasikan: Toast

Bisa ditambah untuk better UX:
<div class="toast" role="alert">
  <div class="toast-header">
    <strong class="me-auto">Success</strong>
  </div>
  <div class="toast-body">Data berhasil disimpan</div>
</div>

JavaScript:
const toast = new bootstrap.Toast(toastElement)
toast.show()
```

---

## 9️⃣ TESTING BOOTSTRAP COMPATIBILITY

### Verifikasi di Browser
```
1. Chrome/Chromium   ✓
2. Firefox           ✓
3. Safari            ✓
4. Edge              ✓
5. Mobile Chrome     ✓
```

### Responsive Testing
```
1. Desktop (1920px)  ✓
2. Tablet (768px)    ✓
3. Mobile (480px)    ✓
```

### Bootstrap Version
```
Version: 5.3.0 (Latest as of this build)
CDN: https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css
JS: https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js
```

---

## 🔟 KESIMPULAN

### ✅ STATUS KESELURUHAN
**Semua 17 file sudah menggunakan Bootstrap dengan OPTIMAL**

### Kekuatan:
1. ✓ Konsistensi penggunaan pattern di semua file
2. ✓ Responsive design dengan proper breakpoint
3. ✓ Grid system yang fleksibel
4. ✓ Component reusability
5. ✓ Proper spacing dan alignment
6. ✓ Bootstrap best practices diterapkan
7. ✓ Mobile-first approach
8. ✓ Accessibility considerations

### Areas Implementation:
- Grid System (row/col)
- Cards (card, card-header, card-body)
- Tables (table, table-responsive, table-hover, table-dark)
- Buttons (btn, btn-primary, btn-secondary, etc)
- Forms (form-label, form-control)
- Badges (badge, bg-warning, text-dark)
- Alerts (alert, alert-success, alert-danger, etc)
- Utilities (d-flex, mb-3, text-muted, etc)

### Optional Enhancements (jika diperlukan):
- [ ] Form validation styling (is-valid, is-invalid)
- [ ] Modal untuk confirm dialog
- [ ] Breadcrumb navigation
- [ ] Pagination untuk table
- [ ] Tooltip/Popover
- [ ] Toast notifications

---

**STATUS: ✅ BOOTSTRAP FULLY IMPLEMENTED & OPTIMIZED**

Aplikasi sudah menggunakan Bootstrap 5.3.0 secara komprehensif di semua halaman dengan best practices yang baik!
