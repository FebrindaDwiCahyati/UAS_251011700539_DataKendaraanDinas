<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['login'])) {
    header("Location:index.php");
    exit;
}

if (isset($_POST['simpan'])) {

    $no_polisi        = mysqli_real_escape_string($koneksi, $_POST['no_polisi']);
    $nama_kendaraan   = mysqli_real_escape_string($koneksi, $_POST['nama_kendaraan']);
    $jenis_kendaraan  = mysqli_real_escape_string($koneksi, $_POST['jenis_kendaraan']);
    $tahun_beli       = $_POST['tahun_beli'];
    $kondisi          = $_POST['kondisi'];
    $penanggung_jawab = mysqli_real_escape_string($koneksi, $_POST['penanggung_jawab']);
    $tanggal_input    = $_POST['tanggal_input'];

    $foto = "";

    if (!empty($_FILES['foto_kendaraan']['name'])) {
        $namaFile = $_FILES['foto_kendaraan']['name'];
        $tmp      = $_FILES['foto_kendaraan']['tmp_name'];
        $ext      = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
        $izin     = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $izin)) {
            $foto = time() . "_" . $namaFile;
            move_uploaded_file($tmp, "upload/" . $foto);
        }
    }

    $simpan = mysqli_query($koneksi, "
        INSERT INTO kendaraan
        (no_polisi, nama_kendaraan, jenis_kendaraan, tahun_beli, kondisi, penanggung_jawab, foto_kendaraan, tanggal_input)
        VALUES
        ('$no_polisi', '$nama_kendaraan', '$jenis_kendaraan', '$tahun_beli', '$kondisi', '$penanggung_jawab', '$foto', '$tanggal_input')
    ");

    if ($simpan) {
        echo "<script>
            alert('Data kendaraan berhasil ditambahkan');
            location='home.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menyimpan data');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Kendaraan</title>
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
            <h4>Tambah Data Kendaraan</h4>
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>No Polisi</label>
                        <input type="text" name="no_polisi" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Nama Kendaraan</label>
                        <input type="text" name="nama_kendaraan" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Mobil">Mobil</option>
                            <option value="Motor">Motor</option>
                            <option value="Pickup">Pickup</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tahun Beli</label>
                        <input type="number" name="tahun_beli" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Kondisi</label>
                        <select name="kondisi" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Baik">Baik</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Penanggung Jawab</label>
                        <input type="text" name="penanggung_jawab" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tanggal Input</label>
                        <input type="date" name="tanggal_input" class="form-control"
                               value="<?= date('Y-m-d'); ?>" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Foto Kendaraan</label>
                        <input type="file" name="foto_kendaraan" class="form-control"
                               accept=".jpg,.jpeg,.png,.webp" onchange="previewImage(event)">
                    </div>

                    <div class="col-md-12 text-center mb-4">
                        <img id="preview" style="display:none; width:220px;">
                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-primary" name="simpan">Simpan</button>
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