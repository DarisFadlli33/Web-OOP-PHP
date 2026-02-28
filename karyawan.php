<?php
require 'koneksi.php';

echo "\n=== MENU KARYAWAN ===\n";
echo "1. Tambah Karyawan\n";
echo "2. Lihat Karyawan\n";
echo "3. Update Karyawan\n";
echo "4. Hapus Karyawan\n";
echo "Pilih: ";
$menu = trim(fgets(STDIN));

if ($menu == 1) {

    echo "Nama Karyawan: ";
    $nama = trim(fgets(STDIN));

    echo "Divisi: ";
    $divisi = trim(fgets(STDIN));

    echo "Jabatan (Manajer / Supervisor / Staff): ";
    $jabatan = trim(fgets(STDIN));

    // VALIDASI JABATAN
    $qJabatan = mysqli_query($conn, "SELECT id FROM jabatan WHERE nama='$jabatan'");
    if (mysqli_num_rows($qJabatan) == 0) {
        echo "❌ Jabatan tidak tersedia!\n";
        exit;
    }
    $id_jabatan = mysqli_fetch_assoc($qJabatan)['id'];

    echo "Rating (1-5): ";
    $rating = trim(fgets(STDIN));
    $qRating = mysqli_query($conn, "SELECT id FROM rating WHERE rating='$rating'");
    $id_rating = mysqli_fetch_assoc($qRating)['id'];

    mysqli_query($conn, "INSERT INTO karyawan (nama, divisi, id_jabatan, id_rating)
                         VALUES ('$nama','$divisi','$id_jabatan','$id_rating')");

    echo "✅ Karyawan berhasil ditambahkan\n";
}

/* ====================== */
if ($menu == 2) {
    $data = mysqli_query($conn, "
        SELECT k.id, k.nama, j.nama AS jabatan, r.rating
        FROM karyawan k
        JOIN jabatan j ON k.id_jabatan=j.id
        JOIN rating r ON k.id_rating=r.id
    ");

    while ($d = mysqli_fetch_assoc($data)) {
        echo "{$d['id']} | {$d['nama']} | {$d['jabatan']} | Rating {$d['rating']}\n";
    }
}

/* ====================== */
if ($menu == 3) {
    echo "ID Karyawan: ";
    $id = trim(fgets(STDIN));

    echo "Nama Baru: ";
    $nama = trim(fgets(STDIN));

    mysqli_query($conn, "UPDATE karyawan SET nama='$nama' WHERE id='$id'");
    echo "✅ Data karyawan diperbarui\n";
}

/* ====================== */
if ($menu == 4) {
    echo "ID Karyawan: ";
    $id = trim(fgets(STDIN));

    mysqli_query($conn, "DELETE FROM karyawan WHERE id='$id'");
    echo "🗑️ Data karyawan dihapus\n";
}
