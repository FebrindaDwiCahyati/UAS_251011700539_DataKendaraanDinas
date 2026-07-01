<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['login'])) {
    header("Location:index.php");
    exit;
}


$id = $_GET['id'];
$data = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE id_kendaraan='$id'")
);

if (isset($_POST['update'])) {

    $no_polisi        = mysqli_real_escape_string($koneksi, $_POST['no_polisi']);
    $nama_kendaraan   = mysqli_real_escape_string($koneksi, $_POST['nama_kendaraan']);
    $jenis_kendaraan  = mysqli_real_escape_string($koneksi, $_POST['jenis_kendaraan']);
    $tahun_beli       = $_POST['tahun_beli'];
    $kondisi          = $_POST['kondisi'];
    $penanggung_jawab = mysqli_real_escape_string($koneksi, $_POST['penanggung_jawab']);
    $tanggal_input    = $_POST['tanggal_input'];

    $foto = $data['foto_kendaraan'];

    /* UPLOAD FOTO */
    if (!empty($_FILES['foto_kendaraan']['name'])) {

        $namaFile = $_FILES['foto_kendaraan']['name'];
        $tmp      = $_FILES['foto_kendaraan']['tmp_name'];
        $ext      = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
        $izin     = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $izin)) {
            $isi_file = file_get_contents($tmp);
            $base64   = base64_encode($isi_file);
            $foto     = "data:image/" . $ext . ";base64," . $base64;
        }
    }

    $update = mysqli_query($koneksi, "
        UPDATE kendaraan SET
            no_polisi='$no_polisi',
            nama_kendaraan='$nama_kendaraan',
            jenis_kendaraan='$jenis_kendaraan',
            tahun_beli='$tahun_beli',
            kondisi='$kondisi',
            penanggung_jawab='$penanggung_jawab',
            foto_kendaraan='$foto',
            tanggal_input='$tanggal_input'
        WHERE id_kendaraan='$id'
    ");

    if ($update) {
        echo "<script>
            alert('Data kendaraan berhasil diubah');
            location='home.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal diubah');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Menu</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<?php include "partials/sidebar.php"; ?>
<div class="content">
<?php include "partials/header.php"; ?>

<div class="container-fluid p-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Edit Data Kendaraan</h4>
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>No Polisi</label>
                        <input type="text" name="no_polisi" class="form-control"
                               value="<?= $data['no_polisi']; ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Nama Kendaraan</label>
                        <input type="text" name="nama_kendaraan" class="form-control"
                               value="<?= $data['nama_kendaraan']; ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" class="form-control" required>
                            <option value="Mobil" <?= ($data['jenis_kendaraan']=="Mobil")?'selected':''; ?>>Mobil</option>
                            <option value="Motor" <?= ($data['jenis_kendaraan']=="Motor")?'selected':''; ?>>Motor</option>
                            <option value="Pickup" <?= ($data['jenis_kendaraan']=="Pickup")?'selected':''; ?>>Pickup</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tahun Beli</label>
                        <input type="number" name="tahun_beli" class="form-control"
                               value="<?= $data['tahun_beli']; ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Kondisi</label>
                        <select name="kondisi" class="form-control" required>
                            <option value="Baik" <?= ($data['kondisi']=="Baik")?'selected':''; ?>>Baik</option>
                            <option value="Rusak Ringan" <?= ($data['kondisi']=="Rusak Ringan")?'selected':''; ?>>Rusak Ringan</option>
                            <option value="Rusak Berat" <?= ($data['kondisi']=="Rusak Berat")?'selected':''; ?>>Rusak Berat</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Penanggung Jawab</label>
                        <input type="text" name="penanggung_jawab" class="form-control"
                               value="<?= $data['penanggung_jawab']; ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tanggal Input</label>
                        <input type="date" name="tanggal_input" class="form-control"
                               value="<?= $data['tanggal_input']; ?>" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Ganti Foto (Opsional)</label>
                        <input type="file" name="foto_kendaraan" class="form-control"
                               accept=".jpg,.jpeg,.png,.webp" onchange="previewImage(event)">
                    </div>

                    <div class="col-md-12 text-center mb-3">
                        <?php if ($data['foto_kendaraan'] != "") { ?>
                            <img id="preview" src="<?= $data['foto_kendaraan']; ?>" width="220">
                        <?php } else { ?>
                            <img id="preview" style="display:none;" width="220">
                        <?php } ?>
                    </div>

                    <div class="col-md-12">
                        <button name="update" class="btn btn-primary">Update</button>
                        <a href="home.php" class="btn btn-secondary">Kembali</a>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<?php include "partials/footer.php"; ?>

<script>
function previewImage(event) {
    let reader = new FileReader();
    reader.onload = function(){
        let img = document.getElementById('preview');
        img.src = reader.result;
        img.style.display = "block";
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
 <script src="assets/bootstrap.min.js"></script>
</body>
</html>