<?php
session_start();

if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username == "admin" && $password == "12345") {

        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;

        header("Location: dashboard.php");
        exit;

    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Absensi Sekolah</title><link rel="stylesheet" href="style.css">
</head>

<body class="login-page">

    <div class="login-box">
        <?php if(file_exists("logo.png")){ ?>
        <img src="logo.png" class="logo">
        <?php } ?>
        <h2>ABSENSI SEKOLAH</h2>
        <p>Silakan login untuk masuk</p>

        <?php if ($error != "") { ?>
         <div class="error">
            <?= $error; ?>
        </div><?php } ?>

    <form method="POST">
        <label>Username</label><input type="text" name="username" required>
        <label>Password</label><input type="password" name="password" required>
        <button type="submit" name="login">LOGIN</button>
    </form>
    <div class="info-login">Username: <b>admin</b><br>Password: <b>12345</b></div>
</div>
</body>
</html>