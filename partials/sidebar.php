<?php
$halaman = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar">
    <div class="logo">
        <img src="assets/image/logo.png" width="70">
        <h3>Kendaraan Dinas</h3>
        <small>Manajemen Data Kendaraan</small>
    </div>

    <ul>
        <li>
            <a href="home.php" class="<?= ($halaman == 'home.php') ? 'active' : ''; ?>">
                Dashboard
            </a>
        </li>

        <li>
            <a href="tambah.php" class="<?= ($halaman == 'tambah.php') ? 'active' : ''; ?>">
                Tambah Kendaraan
            </a>
        </li>

        <li>
            <a href="jenis.php" class="<?= ($halaman == 'jenis.php') ? 'active' : ''; ?>">
                Jenis Kendaraan
            </a>
        </li>

        <li>
            <a href="report.php" class="<?= ($halaman == 'report.php') ? 'active' : ''; ?>">
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