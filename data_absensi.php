<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit; }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Absensi</title>
    
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="header">
        <div><h2>Data Absensi</h2>
        <p>Verifikasi Wajah</p>
    </div>
    <div>
        <span class="admin">
            👤 <?= $_SESSION['username']; ?>
        </span>
        
        <a href="logout.php" class="logout">Logout</a>
    </div>
</div>

<div class="menu">
    <a href="dashboard.php">
        📝 Input Absensi
    </a>
    <a href="data_absensi.php">
        📄 Data Absensi
    </a>
</div>

<div class="card">
<?php if(isset($_GET['success'])){ ?>
    <div class="success">
        ✅ Absensi + Foto Wajah Berhasil Disimpan!
    </div>
<?php } ?>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Foto Wajah</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Ket</th>
            </tr>
        </thead>
        <tbody>

        <?php

        $file="data/absensi.txt";
        if(file_exists($file)){
            $rows=file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $no=1;
            foreach(array_reverse($rows) as $r){
                $d=explode("|",$r);
                if(count($d)>=6){
                    $foto = file_exists($d[5]) ? $d[5] : "https://via.placeholder.com/70";
                    echo "<tr><td>$no</td><td><img src='$foto' width='60' style='border-radius:50%;height:60px;object-fit:cover'></td><td>{$d[0]}</td><td>{$d[1]}</td><td>{$d[2]}</td><td><span class='".strtolower($d[3])."'>{$d[3]}</span></td><td>{$d[4]}</td></tr>";
                    $no++;
                }
            }
        }

        ?>
        </tbody>
    </table>
</div>
</div>
</div>
</body>
</html>