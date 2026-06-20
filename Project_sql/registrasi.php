<?php
include 'config/koneksi.php';

if (isset($_POST['daftar'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'dosen'; // otomatis jadi dosen

    // 🔹 Cek apakah username sudah digunakan
    $cek = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah terdaftar! Gunakan username lain.');</script>";
    } else {
        // 🔹 Simpan akun baru (otomatis role = dosen)
        $query = "INSERT INTO user (nama, username, password, role) VALUES ('$nama','$username','$password','$role')";
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Akun berhasil dibuat! Silakan login.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Gagal membuat akun!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Registrasi Akun</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
<style>
body{
    font-family:'Poppins',sans-serif;
    background:#f1f5f9;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

.form-container{
    width:100%;
    max-width:400px;
    background:#ffffff;
    border-radius:15px;
    padding:35px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

h2{
    text-align:center;
    color:#2c3e50;
    margin-bottom:25px;
    font-weight:600;
}

h2 i{
    color:#3498db;
    margin-right:8px;
}

.field-group{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:18px;
}

.field-group i{
    color:#3498db;
    width:20px;
}

input{
    flex:1;
    height:45px;
    border:1px solid #dcdde1;
    border-radius:8px;
    padding:0 12px;
    font-size:14px;
    transition:.3s;
}

input:focus{
    outline:none;
    border-color:#3498db;
    box-shadow:0 0 0 3px rgba(52,152,219,.15);
}

button{
    width:100%;
    height:48px;
    border:none;
    border-radius:8px;
    background:#3498db;
    color:white;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
    margin-top:10px;
}

button:hover{
    background:#2980b9;
}

button i{
    margin-right:5px;
}

a{
    display:block;
    text-align:center;
    margin-top:15px;
    color:#3498db;
    text-decoration:none;
    font-size:14px;
}

a:hover{
    text-decoration:underline;
}

@media(max-width:480px){
    .form-container{
        padding:25px;
    }
}

body{
    font-family:'Poppins',sans-serif;
    background:#f1f5f9;
    margin:0;
    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    padding:20px;
}

.form-container{
    width:100%;
    max-width:400px;
    background:#fff;
    border-radius:15px;
    padding:35px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}
</style>
</style>
</head>
<body>
<div class="form-container">
    <h2><i class="fas fa-user-plus"></i> Registrasi Dosen</h2>
    <form method="POST">
        <div class="field-group">
            <i class="fas fa-user"></i>
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
        </div>
        <div class="field-group">
            <i class="fas fa-user-tag"></i>
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="field-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" name="daftar"><i class="fas fa-check"></i> Daftar</button>
    </form>
    <a href="login.php"><i class="fas fa-sign-in-alt"></i> Sudah punya akun? Login</a>
</div>
</body>
</html>
