<?php
$host     = "gateway01.ap-southeast-1.prod.aws.tidbcloud.com";
$user     = "3nkBdoh6yKZfSNY.root";
$password = "CbZIpuRuZVGl7TME"; 
$database = "db_kendaraan_dinas";
$port     = 4000;

$koneksi = mysqli_connect($host, $user, $password, $database, $port);

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
}
?>
