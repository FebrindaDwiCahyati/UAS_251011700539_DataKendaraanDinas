<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['login'])) {
    header("Location:index.php");
    exit;
}

if (isset($_GET['id'])) {

    $id = (int) $_GET['id'];

    // Ambil foto kendaraan
    $cek = mysqli_query(
        $koneksi,
        "SELECT foto_kendaraan FROM kendaraan WHERE id_kendaraan='$id'"
    );

    $data = mysqli_fetch_assoc($cek);

    if ($data) {

        // Hapus file foto jika ada
        if ($data['foto_kendaraan'] != "" && file_exists("upload/" . $data['foto_kendaraan'])) {
            unlink("upload/" . $data['foto_kendaraan']);
        }

        // Hapus data kendaraan
        mysqli_query(
            $koneksi,
            "DELETE FROM kendaraan WHERE id_kendaraan='$id'"
        );
    }
}

header("Location:home.php");
exit;
?>