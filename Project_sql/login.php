<?php
session_start();
include 'config/koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];

        if ($data['role'] == 'kaprodi') {
            header("Location: kaprodi_dashboard.php");
            exit;
        } elseif ($data['role'] == 'dosen') {
            header("Location: dosen_dashboard.php");
            exit;
        }
    } else {
        echo "<script>alert('Username atau password salah!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login | Sistem Tugas Dosen</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background:#f4f7fc;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    padding:20px;
}

.form-container{
    width:100%;
    max-width:400px;
    background:#ffffff;
    padding:40px 35px;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    text-align:center;
}

h2{
    color:#2c3e50;
    margin-bottom:30px;
    font-size:26px;
    font-weight:600;
}

h2 i{
    color:#3498db;
    margin-right:8px;
}

.input-group{
    position:relative;
    margin-bottom:20px;
}

.input-group i{
    position:absolute;
    left:15px;
    top:50%;
    transform:translateY(-50%);
    color:#7f8c8d;
}

.input-group input{
    width:100%;
    height:50px;
    border:1px solid #dcdde1;
    border-radius:10px;
    padding-left:45px;
    font-size:15px;
    transition:0.3s;
    background:#fff;
}

.input-group input:focus{
    outline:none;
    border-color:#3498db;
    box-shadow:0 0 0 3px rgba(52,152,219,0.15);
}

button{
    width:100%;
    height:50px;
    border:none;
    border-radius:10px;
    background:#3498db;
    color:white;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#2980b9;
}

button i{
    margin-right:5px;
}

.forgot-pass{
    margin-top:15px;
}

.forgot-pass a{
    color:#3498db;
    text-decoration:none;
    font-size:14px;
}

.forgot-pass a:hover{
    text-decoration:underline;
}

a{
    display:block;
    margin-top:20px;
    text-decoration:none;
    color:#3498db;
    font-size:14px;
}

a:hover{
    text-decoration:underline;
}

.security-note{
    margin-top:20px;
    font-size:13px;
    color:#7f8c8d;
}

.security-note i{
    color:#27ae60;
}

@media(max-width:480px){
    .form-container{
        padding:30px 20px;
    }
}
</style>
</head>
<body>
<div class="form-container">
    <h2><i class="fas fa-university"></i> Login </h2>
    <form method="POST">
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Masukkan Username" required>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Masukkan Password" required>
        </div>
        <button type="submit" name="login"><i class="fas fa-sign-in-alt"></i> Masuk</button>
    </form>

    <div class="forgot-pass">
        <a href="lupa_password.php"><i class="fas fa-key"></i> Lupa Password?</a>
    </div>

    <a href="registrasi.php"><i class="fas fa-user-plus"></i> Belum punya akun? Daftar di sini</a>

    <div class="security-note">
        <i class="fas fa-shield-alt"></i>
        <span>Login Aman & Terlindungi</span>
    </div>
</div>
</body>
</html>
