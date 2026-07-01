<?php
$host     = "gateway01.ap-southeast-1.prod.aws.tidbcloud.com";
$user     = "3nkBdoh6yKZfSNY.root";
$password = "CbzIpuhuzVG17IMt"; 
$database = "db_kendaraan_dinas";
$port     = 4000;

// 1. Inisialisasi objek koneksi MySQLi terlebih dahulu
$koneksi = mysqli_init();

if (!$koneksi) {
    die("mysqli_init gagal");
}

// 2. Aktifkan fitur SSL aman (Wajib untuk TiDB Cloud)
// Nilai parameter dikosongkan karena TiDB mengizinkan handshake otomatis tanpa file CA fisik
mysqli_ssl_set($koneksi, NULL, NULL, NULL, NULL, NULL);

// 3. Lakukan koneksi ke database cloud
if (!mysqli_real_connect($koneksi, $host, $user, $password, $database, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
