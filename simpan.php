<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// MENGAMBIL DATA DAN FOTO BASE64 DARI FORM
$nama = trim($_POST['nama']);
$kelas = trim($_POST['kelas']);
$tanggal = trim($_POST['tanggal']);
$status = trim($_POST['status']);
$keterangan = trim($_POST['keterangan']);
$fotoBase64 = $_POST['foto_base64'];

if ($keterangan == "") { $keterangan = "-"; }

// BUAT FOLDER & SIMPAN FOTO
if (!is_dir("foto")) mkdir("foto", 0777, true);
if (!is_dir("data")) mkdir("data", 0777, true);

$namaFileFoto = "-";
if (!empty($fotoBase64)) {
    $namaFileFoto = "foto/" . date('Ymd_His') . "_" . preg_replace('/[^A-Za-z0-9]/','',$nama) . ".jpg";
    $parts = explode(',', $fotoBase64);
    if(count($parts) > 1){
        file_put_contents($namaFileFoto, base64_decode($parts[1]));
    }
}

// MEMBUAT FORMAT DATA
$data =
$tanggal . "|" . 
$nama . "|" . 
$kelas . "|" . 
$status . "|" . 
$keterangan . "|" . 
$namaFileFoto . 
PHP_EOL;

// MENYIMPAN DATA
file_put_contents(
    "data/absensi.txt", 
    $data, FILE_APPEND
);

header("Location: data_absensi.php?success=1");

exit;

?>