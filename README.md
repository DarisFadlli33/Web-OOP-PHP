# Sistem Manajemen Karyawan - HRM (Human Resource Management)

Aplikasi web berbasis PHP untuk mengelola data karyawan, gaji, jabatan, rating, dan tarif lembur.

## 🎯 Fitur Utama

✅ **Dashboard** - Welcome carousel dan daftar karyawan terbaru dengan slideshow
✅ **Manajemen Karyawan** - CRUD lengkap (Tambah, Lihat, Edit, Hapus, Detail)
✅ **Manajemen Jabatan** - Kelola posisi kerja dengan gaji pokok dan tunjangan
✅ **Manajemen Rating** - Kelola skala penilaian kinerja karyawan
✅ **Tarif Lembur** - Pengaturan tarif lembur per jam
✅ **Perhitungan Gaji** - Hitung gaji otomatis berdasarkan data karyawan
✅ **Database MySQL** - Data tersimpan aman di database
✅ **Responsive Design** - Tampilan optimal di desktop, tablet, dan mobile
✅ **UI/UX Modern** - Interface yang menarik dengan Bootstrap 5

### 🎨 Bootstrap Components (24 Fitur Lengkap)

**Layout & Grid**
- Responsive grid system (col-md, col-lg)
- Flexbox utilities (d-flex, justify-content, align-items)
- Spacing utilities (margin, padding dengan Bootstrap)

**Components**
- Cards dengan card-header dan card-body styling
- Tables responsive dengan table-hover effect
- Buttons dengan 6 variasi warna (primary, secondary, success, danger, warning, info)
- Badges untuk status dan rating
- Alerts untuk notifikasi (success, danger, warning, info)
- Breadcrumb navigation di setiap halaman

**Form & Input**
- Form validation dengan styling visual (is-valid, is-invalid)
- Bootstrap Switches toggle untuk boolean fields
- Custom checkboxes dengan select-all functionality
- Tooltip pada buttons dengan hover description
- Form controls dengan focus styling

**Navigation & Interaction**
- Dropdown menu di topbar dengan divider
- Navigation tabs di detail pages dengan fade transition
- Accordion sections (alternative ke tabs)
- Delete confirmation modal dengan centered dialog
- Toast notifications auto-dismiss (success, danger, warning, info)

**Advanced Features**
- Carousel slideshow untuk galeri karyawan terbaru
- Pagination dengan smart page links
- Bulk delete dengan multi-select
- Responsive hamburger menu untuk mobile
- Sidebar collapse dengan smooth animation

## 📋 Kebutuhan Sistem

- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi (MariaDB juga mendukung)
- Apache/Nginx Server
- XAMPP, WAMP, atau Laragon (untuk development)

## 📦 Instalasi

### 1. Clone atau Download Proyecto

```bash
cd /xampp/htdocs/
# Atau ke lokasi server Anda
```

### 2. Buat Database

Buka phpMyAdmin dan buat database baru:

```sql
CREATE DATABASE kantor;
```

### 3. Import Database

- Buka phpMyAdmin
- Pilih database `kantor`
- Klik tab "Import"
- Pilih file `kantor.sql` dari folder project
- Klik "Go"

Atau melalui command line:

```bash
mysql -u root -p kantor < kantor.sql
```

### 4. Konfigurasi Database

Edit file `config/Database.php` sesuai dengan konfigurasi server Anda:

```php
private $host = "localhost";      // Host MySQL
private $user = "root";            // Username MySQL
private $pass = "";                // Password MySQL
private $db = "kantor";            // Nama Database
```

### 5. Akses Aplikasi

Buka browser dan akses:
```
http://localhost/Database-PHP/
```

## 📂 Struktur Folder

```
Database-PHP/
├── assets/
│   ├── css/
│   │   └── style.css           # Stylesheet
│   └── js/
│       └── main.js             # JavaScript
├── config/
│   └── Database.php            # Database Configuration (OOP)
├── classes/
│   └── Model.php               # Base Model Class
├── models/
│   ├── Karyawan.php           # Model Karyawan
│   ├── Jabatan.php            # Model Jabatan
│   ├── Rating.php             # Model Rating
│   ├── Lembur.php             # Model Lembur
│   └── Gaji.php               # Model Gaji
├── controllers/
│   ├── karyawan-controller.php # Controller Karyawan
│   ├── jabatan-controller.php  # Controller Jabatan
│   ├── rating-controller.php   # Controller Rating
│   ├── lembur-controller.php   # Controller Lembur
│   └── gaji-controller.php     # Controller Gaji
├── views/
│   ├── layout.php              # Layout Header
│   ├── layout-footer.php       # Layout Footer
│   ├── karyawan.php            # List Karyawan
│   ├── karyawan-form.php       # Form Add/Edit Karyawan
│   ├── karyawan-detail.php     # Detail Karyawan
│   ├── jabatan.php             # List Jabatan
│   ├── jabatan-form.php        # Form Add/Edit Jabatan
│   ├── jabatan-detail.php      # Detail Jabatan
│   ├── rating.php              # List Rating
│   ├── rating-form.php         # Form Add/Edit Rating
│   ├── rating-detail.php       # Detail Rating
│   ├── lembur.php              # List Tarif Lembur
│   ├── lembur-form.php         # Form Add/Edit Tarif Lembur
│   ├── lembur-detail.php       # Detail Tarif Lembur
│   ├── gaji.php                # List Gaji
│   ├── gaji-form.php           # Form Hitung Gaji
│   └── gaji-detail.php         # Detail Gaji
├── index.php                   # Entry Point (Dashboard)
├── kantor.sql                  # Database SQL
└── README.md                   # Dokumentasi
```

## 🔐 Fitur Keamanan

- ✅ Input validation dan sanitasi data
- ✅ SQL Injection prevention dengan escape string
- ✅ Session management
- ✅ CSRF protection ready
- ✅ OOP Architecture untuk code quality

## 💾 Database Schema

### Tabel `karyawan`
```sql
- id (Primary Key)
- nama
- divisi
- id_jabatan (Foreign Key)
- id_rating (Foreign Key)
- alamat
- umur
- jenis_kelamin
- status
- created_at
```

### Tabel `jabatan`
```sql
- id (Primary Key)
- nama
- gaji_pokok
- tunjangan
- created_at
```

### Tabel `rating`
```sql
- id (Primary Key)
- rating (1-5)
- presentase_bonus
```

### Tabel `lembur`
```sql
- id (Primary Key)
- tarif (per jam)
```

### Tabel `gaji`
```sql
- id (Primary Key)
- id_karyawan (Foreign Key)
- id_lembur (Foreign Key)
- periode
- lama_lembur
- total_lembur
- total_bonus
- total_tunjangan
- total_pendapatan
- created_at
```

## 📖 Panduan Penggunaan

### 1. Dashboard
- Tampilan welcome screen
- Statistik jumlah karyawan, jabatan, rating, dan gaji
- Daftar karyawan terbaru

### 2. Manajemen Karyawan
- **Daftar Karyawan**: Lihat semua karyawan dalam tabel
- **Tambah Karyawan**: Isi form dengan data lengkap
- **Edit Karyawan**: Ubah data karyawan existing
- **Detail Karyawan**: Lihat informasi lengkap karyawan
- **Hapus Karyawan**: Hapus data karyawan

### 3. Perhitungan Gaji
- Pilih karyawan dari dropdown
- Masukkan jumlah jam lembur
- Sistem otomatis menghitung:
  - Gaji Pokok (dari Jabatan)
  - Tunjangan (dari Jabatan)
  - Total Lembur (Jam × Tarif Lembur)
  - Bonus (Gaji Pokok × Presentase Rating)
  - **Total Gaji = Gaji Pokok + Tunjangan + Lembur + Bonus**

## 🎨 Customization

### Mengubah Warna Tema
Edit file `assets/css/style.css`:
```css
:root {
    --primary-color: #4e73df;    /* Warna utama */
    --secondary-color: #858796;
    --success-color: #1cc88a;
    --danger-color: #e74c3c;
    --warning-color: #f8b500;
}
```

### Mengubah Logo/Nama Aplikasi
Edit di `views/layout.php`:
```php
<h3><i class="fas fa-users"></i> HRM</h3>
<small>Human Resource Management</small>
```

## 🐛 Troubleshooting

### Error: Database Connection Failed
- Periksa konfigurasi di `config/Database.php`
- Pastikan MySQL running
- Periksa username dan password MySQL

### Error: Table Not Found
- Import database dengan file `kantor.sql`
- Gunakan command: `mysql -u root -p kantor < kantor.sql`

### Error: File Not Found
- Pastikan folder struktur sesuai
- Periksa path BASE_URL di setiap file
- Jika menggunakan subdomain, sesuaikan BASE_URL

## 🚀 Deployment

1. Upload semua file ke server hosting
2. Update konfigurasi database di `config/Database.php`
3. Import database di hosting
4. Akses melalui domain Anda

## 📝 Catatan

- Semua foto/dokumen dapat ditambahkan dengan modifikasi database
- Email notification dapat ditambahkan dengan library mailer
- Export gaji ke Excel dapat diimplementasikan dengan PHPExcel
- Authentication/Login dapat ditambahkan sesuai kebutuhan

## 📞 Support & Kontribusi

Jika menemukan bug atau memiliki saran, silakan buat issue atau pull request.

## 📄 Lisensi

MIT License - Bebas digunakan untuk keperluan komersial dan personal.

---

**Dibuat dengan ❤️ menggunakan PHP OOP, Bootstrap 5 & MySQL**
