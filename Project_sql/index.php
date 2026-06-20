<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistem Manajemen Tugas Dosen & Kaprodi</title>

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
    background:#f4f6f9;
    color:#333;
    min-height:100vh;
}

/* HEADER */
header{
    background:#1e3a8a;
    color:white;
    text-align:center;
    padding:60px 20px;
}

.header-content i{
    font-size:70px;
    margin-bottom:15px;
}

.header-content h1{
    font-size:2.5rem;
    font-weight:600;
}

.header-content p{
    margin-top:10px;
    font-size:1rem;
    opacity:0.9;
}

/* HERO */
.hero{
    max-width:900px;
    margin:40px auto;
    padding:40px;
    text-align:center;
}

.hero-icon{
    font-size:70px;
    color:#2563eb;
    margin-bottom:20px;
}

.hero h2{
    color:#1e3a8a;
    margin-bottom:15px;
}

.hero p{
    color:#555;
    line-height:1.8;
    font-size:1.05rem;
}

/* BUTTON */
.hero-btn{
    margin-top:30px;
    display:flex;
    justify-content:center;
    gap:15px;
    flex-wrap:wrap;
}

.hero-btn a{
    text-decoration:none;
    background:#2563eb;
    color:white;
    padding:12px 25px;
    border-radius:8px;
    font-weight:500;
    transition:all .3s ease;
    border:2px solid transparent;
    box-shadow:
        0 0 5px rgba(37,99,235,0.4),
        0 0 10px rgba(37,99,235,0.3);
}

.hero-btn a:hover{
    background:#1d4ed8;
    transform:translateY(-3px);
    border-color:#60a5fa;
    box-shadow:
        0 0 10px #60a5fa,
        0 0 20px #60a5fa,
        0 0 30px rgba(96,165,250,0.7);
}

.hero-btn i{
    margin-right:8px;
}

/* FITUR */
.fitur{
    max-width:1100px;
    margin:20px auto 50px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
    padding:0 20px;
}

.card{
    background:white;
    border-radius:12px;
    padding:30px;
    text-align:center;
    box-shadow:0 2px 12px rgba(0,0,0,0.08);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card i{
    font-size:40px;
    color:#2563eb;
    margin-bottom:15px;
}

.card h3{
    color:#1e3a8a;
    margin-bottom:10px;
}

.card p{
    color:#555;
    line-height:1.6;
}

/* FOOTER */
footer{
    background:#1e293b;
    color:white;
    text-align:center;
    padding:20px;
    margin-top:30px;
}

footer i{
    margin-left:5px;
}

/* RESPONSIVE */
@media(max-width:768px){

    .header-content h1{
        font-size:2rem;
    }

    .header-content i{
        font-size:55px;
    }

    .hero{
        padding:25px;
    }

    .hero h2{
        font-size:1.7rem;
    }

    .hero-icon{
        font-size:55px;
    }
}
</style>
</head>

<body>

<header>
    <div class="header-content">
        <i class="fas fa-university"></i>
        <h1>Sistem Manajemen Tugas Dosen</h1>
        <p>Platform Pengelolaan Tugas antara Kaprodi dan Dosen</p>
    </div>
</header>

<section class="hero">

    <i class="fas fa-chalkboard-teacher hero-icon"></i>

    <h2>Selamat Datang 👋</h2>

    <p>
        Sistem ini dirancang untuk membantu Kaprodi dalam memberikan tugas kepada dosen
        serta memantau progres penyelesaian tugas secara lebih efektif dan terstruktur.
        Dosen juga dapat mengunggah hasil tugas langsung melalui sistem ini.
    </p>

    <div class="hero-btn">

        <a href="login.php">
            <i class="fas fa-sign-in-alt"></i>
            Login
        </a>

        <a href="registrasi.php">
            <i class="fas fa-user-plus"></i>
            Registrasi
        </a>

    </div>

</section>

<section class="fitur">

    <div class="card">
        <i class="fas fa-tasks"></i>
        <h3>Kelola Tugas</h3>
        <p>Kaprodi dapat membuat, mengubah, dan menghapus tugas dengan mudah.</p>
    </div>

    <div class="card">
        <i class="fas fa-chart-line"></i>
        <h3>Monitoring Progress</h3>
        <p>Memantau status pengerjaan tugas yang sedang dikerjakan oleh dosen.</p>
    </div>

    <div class="card">
        <i class="fas fa-upload"></i>
        <h3>Upload Hasil</h3>
        <p>Dosen dapat mengunggah hasil tugas langsung ke dalam sistem.</p>
    </div>

</section>

<footer>
    <p>
        &copy; 2026 - Sistem Manajemen Tugas Dosen & Kaprodi
        <i class="fas fa-university"></i>
    </p>
</footer>

</body>
</html>