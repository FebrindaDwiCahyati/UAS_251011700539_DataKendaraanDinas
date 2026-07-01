<?php
include "koneksi.php";
session_start();
if (!isset($_SESSION['login'])) {
    header("Location:index.php");
    exit;
}

$jenis = mysqli_query($koneksi, "
    SELECT DISTINCT jenis_kendaraan 
    FROM kendaraan 
    ORDER BY jenis_kendaraan ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kendaraan per Jenis</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include "partials/sidebar.php"; ?>
<div class="content">
<?php include "partials/header.php"; ?>

<div class="container-fluid p-4">
<h4 class="mb-4">Data Kendaraan per Jenis</h4>

<?php while ($j = mysqli_fetch_assoc($jenis)) :
    $jenis_kendaraan = $j['jenis_kendaraan'];
    $total = mysqli_fetch_assoc(mysqli_query(
        $koneksi,
        "SELECT COUNT(*) AS total FROM kendaraan WHERE jenis_kendaraan='$jenis_kendaraan'"
    ));
?>

<div class="card shadow mb-4">
    <div class="card-header text-white d-flex justify-content-between" style="background:#0d6efd;">
        <span><?= $jenis_kendaraan; ?></span>
        <span class="badge" style="background-color:#dbeafe;color:#1e40af;"><?= $total['total']; ?> Unit</span>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>Foto</th>
                    <th>No Polisi</th>
                    <th>Nama</th>
                    <th>Tahun</th>
                    <th>Kondisi</th>
                    <th>Penanggung Jawab</th>
                    <th>Tanggal</th>
                    <th width="130">Aksi</th>
                </tr>
            </thead>
            <tbody>

            <?php
            $data = mysqli_query($koneksi, "
                SELECT * FROM kendaraan 
                WHERE jenis_kendaraan='$jenis_kendaraan'
                ORDER BY nama_kendaraan ASC
            ");

            while ($row = mysqli_fetch_assoc($data)) :
            ?>
                <tr>
                    <td class="text-center">
                        <?php if ($row['foto_kendaraan']) { ?>
                            <img src="<?= $row['foto_kendaraan']; ?>" width="80">
                        <?php } else echo "-"; ?>
                    </td>
                    <td><?= $row['no_polisi']; ?></td>
                    <td><?= $row['nama_kendaraan']; ?></td>
                    <td class="text-center"><?= $row['tahun_beli']; ?></td>
                    <td class="text-center"><?= $row['kondisi']; ?></td>
                    <td><?= $row['penanggung_jawab']; ?></td>
                    <td class="text-center"><?= date('d-m-Y', strtotime($row['tanggal_input'])); ?></td>
                    <td class="text-center">
                        <a href="edit.php?id=<?= $row['id_kendaraan']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus.php?id=<?= $row['id_kendaraan']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>

            </tbody>
        </table>
    </div>
</div>

<?php endwhile; ?>
</div>

<?php include "partials/footer.php"; ?>
</div>

<script src="assets/bootstrap.min.js"></script>
</body>
</html>