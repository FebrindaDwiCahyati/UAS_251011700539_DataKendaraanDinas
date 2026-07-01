<?php
error_reporting(E_ALL & ~E_DEPRECATED);
$host     = "gateway01.ap-southeast-1.prod.aws.tidbcloud.com";
$user     = "3nkBdoh6yKZfSNY.root";
$password = "CbZIpuRuZVGl7TME"; 
$database = "db_kendaraan_dinas";
$port     = 4000;

$koneksi = mysqli_init();

if (!$koneksi) {
    die("mysqli_init gagal");
}

mysqli_ssl_set($koneksi, NULL, NULL, NULL, NULL, NULL);

if (!mysqli_real_connect($koneksi, $host, $user, $password, $database, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(128) PRIMARY KEY,
    data TEXT,
    last_access INT
)");

function session_open_custom($path, $name) {
    return true;
}

function session_close_custom() {
    return true;
}

function session_read_custom($id) {
    global $koneksi;
    $id = mysqli_real_escape_string($koneksi, $id);
    $hasil = mysqli_query($koneksi, "SELECT data FROM sessions WHERE id = '$id'");
    $baris = mysqli_fetch_assoc($hasil);
    if ($baris) {
        return $baris['data'];
    }
    return "";
}

function session_write_custom($id, $data) {
    global $koneksi;
    $id = mysqli_real_escape_string($koneksi, $id);
    $data = mysqli_real_escape_string($koneksi, $data);
    $waktu = time();
    mysqli_query($koneksi, "REPLACE INTO sessions (id, data, last_access) VALUES ('$id', '$data', $waktu)");
    return true;
}

function session_destroy_data($id) {
    global $koneksi;
    $id = mysqli_real_escape_string($koneksi, $id);
    mysqli_query($koneksi, "DELETE FROM sessions WHERE id = '$id'");
    return true;
}

function session_gc_custom($max_lifetime) {
    global $koneksi;
    $batas = time() - $max_lifetime;
    mysqli_query($koneksi, "DELETE FROM sessions WHERE last_access < $batas");
    return true;
}

session_set_save_handler(
    "session_open_custom",
    "session_close_custom",
    "session_read_custom",
    "session_write_custom",
    "session_destroy_data",
    "session_gc_custom"
);
?>