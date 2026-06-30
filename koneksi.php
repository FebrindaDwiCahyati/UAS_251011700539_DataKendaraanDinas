<?php
$server = "localhost"; 
$username = "root";
$password = ""; 
$db = "db_kendaraan_dinas";
$port = 3307;

$koneksi = mysqli_connect($server, $username, $password, $db, $port);

if (!$koneksi) {
    die("Koneksi gagal akibat: " . mysqli_connect_error());
}
?>
