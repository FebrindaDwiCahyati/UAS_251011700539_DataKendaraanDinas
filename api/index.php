<?php
include "koneksi.php";
session_start();

if (isset($_SESSION['login'])) {
    header("Location: home.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $query = mysqli_query(
    $koneksi,
    "SELECT * FROM users 
     WHERE username='$username' 
     AND PASSWORD='$password'"
);

    if (mysqli_num_rows($query) == 1) {
        $user = mysqli_fetch_assoc($query);

        $_SESSION['login'] = true;
        $_SESSION['username'] = $user['username'];

        header("Location: home.php");
        exit;
    } else {
        $error = "Username atau Password salah";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Kendaraan Dinas</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body {
            background:
                linear-gradient(rgba(0,0,0,.35), rgba(0,0,0,.35)),
                url('assets/image/latarbelakang.jpg');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;

            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-card {
            width: 430px;
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0,0,0,.2);
        }
        .login-header {
            background: #0d6efd;
            color: white;
            padding: 25px;
            text-align: center;
        }
        .login-body {
            background: white;
            padding: 35px;
        }
        .form-control {
            height: 48px;
        }
        .btn-login {
            background: #0d6efd;
            color: white;
            height: 48px;
        }
        .btn-login:hover {
            background: #0d6efd;
            color: white;
        }
       .logo-box{
            width:160px;
            height:160px;
            margin:0 auto -10px;
            display:flex;
            justify-content:center;
            align-items:center;
            border-radius:15px;
            padding:8px;
        }

        .logo-box img{
            width:100%;
            height:100%;
            object-fit:contain;
        }
    </style>
</head>
<body>

<div class="card login-card">
    <div class="login-header">
        <div class="logo-box">
            <img src="assets/image/logo.png" alt="Logo">
        </div>
        <h3>Data Kendaraan Dinas</h3>
        <p>Sistem Entry Data Kendaraan</p>
    </div>

    <div class="login-body">
        <?php if ($error != "") { ?>
            <div class="alert alert-danger">
                <?= $error; ?>
            </div>
        <?php } ?>

        <form method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-4">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-login w-100" name="login">Masuk</button>
        </form>
    </div>
</div>

</body>
</html>
