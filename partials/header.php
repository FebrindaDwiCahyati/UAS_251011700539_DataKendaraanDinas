<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$nama_file = basename($_SERVER['PHP_SELF']);

if ($nama_file == 'home.php') {
    $page_title = "Dashboard";
} elseif ($nama_file == 'tambah.php') {
    $page_title = "Tambah Kendaraan";
} elseif ($nama_file == 'edit.php') {
    $page_title = "Edit Kendaraan";
} elseif ($nama_file == 'kategori.php') {
    $page_title = "Jenis Kendaraan";
} elseif ($nama_file == 'report.php') {
    $page_title = "Laporan Kendaraan";
} else {
    $page_title = "Dashboard";
}
?>

<div class="topbar" style="display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h4 style="margin:0; font-weight:bold;">
            <?= $page_title; ?>
        </h4>
        <small style="color:#666;">
            Sistem Informasi <b>Kendaraan Dinas</b>
        </small>
    </div>
    <div style="font-weight:600;">
        👤 Admin
    </div>
</div>