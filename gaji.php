<?php
require 'koneksi.php';

echo "ID Karyawan: ";
$id = trim(fgets(STDIN));

echo "Jumlah Jam Lembur: ";
$jam = trim(fgets(STDIN));

$data = mysqli_query($conn, "
SELECT k.id, j.gaji_pokok, j.tunjangan, r.presentase_bonus
FROM karyawan k
JOIN jabatan j ON k.id_jabatan=j.id
JOIN rating r ON k.id_rating=r.id
WHERE k.id='$id'
");

if (mysqli_num_rows($data) == 0) {
    echo "❌ Karyawan tidak ditemukan\n";
    exit;
}

$d = mysqli_fetch_assoc($data);

$tarif = mysqli_fetch_assoc(mysqli_query($conn, "SELECT tarif FROM lembur"))['tarif'];

$total_lembur = $jam * $tarif;
$bonus = ($d['gaji_pokok'] * $d['presentase_bonus']) / 100;
$total_gaji = $d['gaji_pokok'] + $d['tunjangan'] + $total_lembur + $bonus;

mysqli_query($conn, "
INSERT INTO gaji
(id_karyawan, id_lembur, periode, lama_lembur, total_lembur, total_bonus, total_tunjangan, total_pendapatan)
VALUES
('$id',1,YEAR(CURDATE()),'$jam','$total_lembur','$bonus','{$d['tunjangan']}','$total_gaji')
");

echo "\n💰 TOTAL GAJI\n";
echo "Gaji Pokok   : {$d['gaji_pokok']}\n";
echo "Tunjangan    : {$d['tunjangan']}\n";
echo "Lembur       : $total_lembur\n";
echo "Bonus        : $bonus\n";
echo "----------------------\n";
echo "TOTAL GAJI   : $total_gaji\n";
