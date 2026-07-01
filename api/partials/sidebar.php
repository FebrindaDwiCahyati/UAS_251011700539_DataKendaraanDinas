<?php
// Deteksi URL yang sedang aktif di browser
$request_uri = $_SERVER['REQUEST_URI'];
?>

<div class="sidebar">
    <div class="logo">
        <img src="../assets/image/logo.png" width="70">
        <h3>Kendaraan Dinas</h3>
        <small>Manajemen Data Kendaraan</small>
    </div>

    <ul>
        <li>
            <a href="home.php" class="<?= (strpos($request_uri, 'home.php') !== false) ? 'active' : ''; ?>">
                Dashboard
            </a>
        </li>

        <li>
            <a href="tambah.php" class="<?= (strpos($request_uri, 'tambah.php') !== false) ? 'active' : ''; ?>">
                Tambah Kendaraan
            </a>
        </li>

        <li>
            <a href="jenis.php" class="<?= (strpos($request_uri, 'jenis.php') !== false) ? 'active' : ''; ?>">
                Jenis Kendaraan
            </a>
        </li>

        <li>
            <a href="report.php" class="<?= (strpos($request_uri, 'report.php') !== false) ? 'active' : ''; ?>">
                Cetak Laporan
            </a>
        </li>

        <li>
            <a href="logout.php">
                Logout
            </a>
        </li>
    </ul>
</div>
