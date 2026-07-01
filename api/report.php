<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['login'])) {
    header("Location:index.php");
    exit;
}

require_once('vendor/autoload.php');

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// setting PDF
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetCreator('Sistem Kendaraan Dinas');
$pdf->SetAuthor('Admin');
$pdf->SetTitle('Laporan Kendaraan Dinas');

$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage();

// ================= HTML =================
$html = '
<h2 align="center"><b>LAPORAN DATA KENDARAAN DINAS</b></h2>
<h3 align="center">INSTANSI / PERUSAHAAN</h3>
<hr style="border:none; height:2px; background-color:#000;">
<br>

<p><b>Tanggal Cetak :</b> ' . date('d-m-Y') . '</p>

<table border="1" cellpadding="4" style="font-size:9pt;">
    <tr bgcolor="#E6E6E6" align="center" style="font-weight:bold;">
        <th width="8%">No</th>
        <th width="16%">No Polisi</th>
        <th width="22%">Nama Kendaraan</th>
        <th width="12%">Jenis</th>
        <th width="10%">Tahun</th>
        <th width="14%">Kondisi</th>
        <th width="18%">Penanggung Jawab</th>
    </tr>
';

$no = 1;
$query = mysqli_query($koneksi, "
    SELECT * FROM kendaraan 
    ORDER BY jenis_kendaraan, nama_kendaraan
");

while ($d = mysqli_fetch_assoc($query)) {
    $html .= '
    <tr>
        <td align="center">'.$no++.'</td>
        <td align="center">'.$d['no_polisi'].'</td>
        <td>'.$d['nama_kendaraan'].'</td>
        <td align="center">'.$d['jenis_kendaraan'].'</td>
        <td align="center">'.$d['tahun_beli'].'</td>
        <td align="center">'.$d['kondisi'].'</td>
        <td>'.$d['penanggung_jawab'].'</td>
    </tr>
    ';
}

$html .= '
</table>

<br><br><br>

<table border="0" style="font-size:10pt;">
    <tr>
        <td width="65%"></td>
        <td width="35%" align="center">
            Mengetahui,<br>
            Admin Sistem
            <br><br><br><br>
            <b>__________________</b>
        </td>
    </tr>
</table>
';

// cetak PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Laporan_Kendaraan_Dinas.pdf', 'I');
?>