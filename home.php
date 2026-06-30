<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location:index.php");
    exit;
}

include "koneksi.php";

/* STATISTIK */
$jml_kendaraan = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) total FROM kendaraan")
);

$jml_jenis = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(DISTINCT jenis_kendaraan) total FROM kendaraan")
);

$jml_baik = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) total FROM kendaraan WHERE kondisi='Baik'")
);

$jml_rusak_ringan = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) total FROM kendaraan WHERE kondisi='Rusak Ringan'")
);

$jml_rusak_berat = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) total FROM kendaraan WHERE kondisi='Rusak Berat'")
);

/* DATA */
$data = mysqli_query($koneksi, "SELECT * FROM kendaraan ORDER BY id_kendaraan ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    
<?php include "partials/sidebar.php"; ?>
<div class="content">
<?php include "partials/header.php"; ?>
<div class="container-fluid p-4">

    <!-- CARD STATISTIK -->
    <div class="row mb-4">
        <div class="col-lg col-md-4 col-6 mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <h6>Total Kendaraan</h6>
                    <h2 style="color:#0d6efd;"><?= $jml_baik['total']; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-4 col-6 mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <h6>Jumlah Jenis</h6>
                    <h2 style="color:#0d6efd;"><?= $jml_baik['total']; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-4 col-6 mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <h6>Kondisi Baik</h6>
                    <h2 style="color:#0d6efd;"><?= $jml_baik['total']; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-4 col-6 mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <h6>Rusak Ringan</h6>
                    <h2 style="color:#0d6efd;"><?= $jml_rusak_ringan['total']; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-4 col-6 mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <h6>Rusak Berat</h6>
                    <h2 style="color:#0d6efd;"><?= $jml_rusak_berat['total']; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Kendaraan Dinas</h5>
            <a href="tambah.php" class="btn btn-primary">Tambah Kendaraan</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>No Polisi</th>
                            <th>Nama Kendaraan</th>
                            <th>Jenis</th>
                            <th>Tahun</th>
                            <th>Kondisi</th>
                            <th>Penanggung Jawab</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($data)) { ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <?php if ($row['foto_kendaraan'] == "") { ?>
                                    -
                                <?php } else { ?>
                                    <img src="upload/<?= $row['foto_kendaraan']; ?>" width="80">
                                <?php } ?>
                            </td>
                            <td><?= $row['no_polisi']; ?></td>
                            <td><?= $row['nama_kendaraan']; ?></td>
                            <td>
                                <span class="badge" style="background-color:#dbeafe;color:#1e40af;"><?= $row['jenis_kendaraan']; ?></span>
                            </td>
                            </td>
                            <td><?= $row['tahun_beli']; ?></td>
                            <td>
                                <span class="badge" style="background-color:#d1e7dd;color:#0f5132;"><?= $row['kondisi']; ?></span>
                            </td>
                            </td>
                            <td><?= $row['penanggung_jawab']; ?></td>
                            <td><?= date('d-m-Y', strtotime($row['tanggal_input'])); ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id_kendaraan']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="hapus.php?id=<?= $row['id_kendaraan']; ?>" class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include "partials/footer.php"; ?>
<script src="assets/bootstrap.min.js"></script>
</body>
</html>