<?php
include 'config/koneksi.php';

if (isset($_POST['reset'])) {
    $username = $_POST['username'];
    $newpass = $_POST['newpass'];

    $cek = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($koneksi, "UPDATE user SET password='$newpass' WHERE username='$username'");
        echo "<script>alert('Password berhasil diubah! Silakan login kembali.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Username tidak ditemukan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Lupa Password</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #0f0f23, #1a1a2e, #16213e);
    color: #e0e6ed;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.container {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(116,185,255,0.3);
    border-radius: 20px;
    padding: 40px;
    width: 350px;
    text-align: center;
}
input {
    width: 100%;
    margin: 10px 0;
    padding: 10px;
    border-radius: 8px;
    border: none;
    background: rgba(15,15,35,0.7);
    color: #fff;
}
button {
    background: linear-gradient(135deg, #74b9ff, #0984e3);
    border: none;
    color: #fff;
    padding: 10px 20px;
    border-radius: 50px;
    cursor: pointer;
}
a {
    display: block;
    margin-top: 15px;
    color: #74b9ff;
    text-decoration: none;
}
</style>
</head>
<body>
<div class="container">
    <h2>Lupa Password</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Masukkan Username" required>
        <input type="password" name="newpass" placeholder="Password Baru" required>
        <button type="submit" name="reset">Reset Password</button>
    </form>
    <a href="login.php">Kembali ke Login</a>
</div>
</body>
</html>
