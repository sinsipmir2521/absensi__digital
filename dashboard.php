<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absensi</title>
    
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

    <!--HEADER-->

    <div class="header">
        <div>
            <h2>Dashboard Absensi</h2>
            <p>Sistem Absensi Sekolah + Verifikasi Wajah</p>
        </div>
        <div>
            <span class="admin">
                👤 <?= $_SESSION['username']; ?>
            </span>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </div>

    <!--MENU-->

    <div class="menu">
        <a href="dashboard.php">
            📝 Input Absensi
        </a>
        <a href="data_absensi.php">
            📄 Data Absensi
        </a>
    </div>

    <!--FORM-->

    <div class="card">
        <h3>📋 Form Absensi Siswa</h3>
        <!-- WRAPPER 2 KOLOM -->
        <div class="form-wrapper">
            <div class="form-kiri">
                <form action="simpan.php" method="POST" onsubmit="return validasiWajah()">
                    <label>Nama Siswa</label>
                    <input type="text" name="nama" placeholder="Masukkan nama siswa" required>

                    <label>Kelas</label>
                    <select name="kelas" required>
                        <option value="">-- Pilih Kelas --</option>
                        <option value="X TKJ 1">X TKJ 1</option><option value="X TKJ 2">X TKJ 2</option>
                        <option value="X RPL 1">X RPL 1</option><option value="X RPL 2">X RPL 2</option>
                        <option value="XI TKJ">XI TKJ</option><option value="XI RPL">XI RPL</option>
                        <option value="XII TKJ">XII TKJ</option><option value="XII RPL">XII RPL</option>
                    </select>

                    <label>Tanggal</label>
                    <input type="date" name="tanggal" value="<?= date('Y-m-d'); ?>" required>

                    <label>Status Kehadiran</label>
                    <select name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Hadir">Hadir</option>
                        <option value="Izin">Izin</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Alpa">Alpa</option>
                    </select>

                    <label>Keterangan</label>
                    <textarea name="keterangan" placeholder="Masukkan keterangan jika ada" rows="4"></textarea>

                    <!-- INPUT FOTO WAJAH -->
                    <input type="hidden" name="foto_base64" id="foto_base64">
                    <button type="submit">💾 SIMPAN ABSENSI + VERIFIKASI WAJAH</button>
                </form>
            </div>

            <!-- KAMERA -->
            <div class="kamera-kanan">
                <h4>📸 Verifikasi Wajah</h4>
                <p style="font-size:12px">Posisikan wajah di tengah</p>
                <div style="position:relative">
                    <video id="video" autoplay playsinline></video>
                    <canvas id="overlay" style="position:absolute;top:0;left:0;width:100%;height:100%"></canvas>
                </div>
                <canvas id="canvas" style="display:none"></canvas>
                <img id="preview" style="display:none;width:100%;border-radius:10px">
                <div class="kamera-btn">
                    <button type="button" onclick="bukaKamera()" style="background:#2563eb">1. Buka Kamera</button>
                    <button type="button" onclick="ambilFoto()" style="background:#16a34a">2. Ambil Foto & Verifikasi</button>
                </div>
                <p id="statusFoto" style="font-weight:bold;color:red;margin-top:10px">❌ Wajah belum diverifikasi</p>
            </div>
        </div>
    </div>
</div>

<!-- TAMBAHAN KODE BARU: SCRIPT KAMERA VERIFIKASI WAJAH -->
<script>
let stream;
const video=document.getElementById('video'), canvas=document.getElementById('canvas'), preview=document.getElementById('preview'), inputFoto=document.getElementById('foto_base64'), statusFoto=document.getElementById('statusFoto');
async function bukaKamera(){
    try{
        stream=await navigator.mediaDevices.getUserMedia({video:{facingMode:"user", width:640, height:480}});
        video.srcObject=stream;
    }catch(e){ alert("Kamera error: "+e.message); }
}
function ambilFoto(){
    if(!stream){ alert("Buka kamera dulu!"); return; }
    canvas.width=video.videoWidth; canvas.height=video.videoHeight;
    canvas.getContext('2d').drawImage(video,0,0);
    const dataURL=canvas.toDataURL('image/jpeg',0.9);
    inputFoto.value=dataURL;
    preview.src=dataURL;
    preview.style.display='block'; video.style.display='none';
    statusFoto.innerHTML="✅ Wajah Terverifikasi"; statusFoto.style.color="green";
}
function validasiWajah(){
    if(inputFoto.value==""){ alert("WAJIB verifikasi wajah! Klik 'Buka Kamera' lalu 'Ambil Foto' di kanan."); return false; }
    return true;
}
</script>
</body></html>