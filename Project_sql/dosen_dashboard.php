<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'dosen') {
    header("Location: login.php");
    exit;
}

$dosen_id = $_SESSION['user_id'];
$nama_dosen = $_SESSION['nama'];

// Cek tugas baru (belum diupload) untuk notifikasi
$notif_query = mysqli_query($koneksi, "SELECT * FROM tugas WHERE dosen_id='$dosen_id' AND file_upload IS NULL ORDER BY id DESC");
$tugas_belum_upload = mysqli_num_rows($notif_query);

// Upload file tugas
if (isset($_POST['upload'])) {
    $id = $_POST['id'];
    $file = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];
    $folder = "uploads/";

    if (!file_exists($folder)) mkdir($folder, 0777, true);

    if (move_uploaded_file($tmp, $folder . $file)) {mysqli_query($koneksi, "UPDATE tugas
        SET
            file_upload='$file',
            id_status='3'
        WHERE id='$id'
        AND dosen_id='$dosen_id'
    ");

    echo "<script>
        alert('File berhasil diupload!');
        window.location='dosen_dashboard.php';
    </script>";

    } else {
        echo "<script>alert('Gagal upload file!');</script>";
    }
}

// Ubah status menjadi Sedang Dikerjakan
if(isset($_GET['kerjakan'])){
    $id = $_GET['kerjakan'];

    mysqli_query($koneksi,"
        UPDATE tugas
        SET id_status='2'
        WHERE id='$id'
        AND dosen_id='$dosen_id'
    ");

    header("Location: dosen_dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Dosen</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
<style>
body{
    font-family:'Poppins',sans-serif;
    background:#f4f6f9;
    color:#333;
    margin:0;
    padding:0;
    min-height:100vh;
}

header{
    background:#2c3e50;
    color:#fff;
    padding:20px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

header h2{
    margin:0;
    font-weight:600;
    color:#fff;
    display:flex;
    align-items:center;
    gap:10px;
}

.logout-btn{
    background:#3498db;
    color:#fff;
    padding:10px 20px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-weight:600;
    transition:0.3s;
}

.logout-btn:hover{
    background:#2980b9;
}

main{
    padding:30px;
}

.table-container{
    background:#fff;
    border-radius:12px;
    padding:25px;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

h3{
    color:#2c3e50;
    text-align:center;
    margin-bottom:25px;
    display:flex;
    justify-content:center;
    align-items:center;
    gap:10px;
}

table{
    width:100%;
    border-collapse:collapse;
    color:#333;
}

th,
td{
    padding:12px;
    text-align:left;
    border-bottom:1px solid #e0e0e0;
}

th{
    background:#3498db;
    color:white;
}

tr:hover{
    background:#f8f9fa;
}

button.upload-btn{
    background:#3498db;
    border:none;
    border-radius:8px;
    padding:8px 15px;
    color:#fff;
    cursor:pointer;
    transition:0.3s;
    font-weight:600;
}

button.upload-btn:hover{
    background:#2980b9;
}

input[type="file"]{
    background:#f8f9fa;
    border:1px solid #ddd;
    border-radius:6px;
    padding:8px;
    color:#333;
}

input[type="file"]:focus{
    outline:none;
    border-color:#3498db;
}

footer{
    text-align:center;
    color:#7f8c8d;
    padding:15px;
    margin-top:30px;
}

.notif-badge{
    position:absolute;
    top:-8px;
    right:-8px;
    background:#e74c3c;
    color:#fff;
    font-size:12px;
    font-weight:600;
    padding:2px 6px;
    border-radius:50%;
}

.notif-dropdown{
    display:none;
    position:absolute;
    right:0;
    top:30px;
    background:#fff;
    min-width:250px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.15);
    z-index:100;
    overflow:hidden;
}

.notif-dropdown a{
    display:block;
    padding:10px 15px;
    color:#333;
    text-decoration:none;
    border-bottom:1px solid #eee;
}

.notif-dropdown a:hover{
    background:#f4f6f9;
}

.notif-container{
    position:relative;
}

@media(max-width:768px){
    header{
        flex-direction:column;
        gap:15px;
    }

    main{
        padding:15px;
    }

    .table-container{
        overflow-x:auto;
    }

    table{
        min-width:700px;
    }
}
</style>
</style>
</head>
<body>
<header>
    <h2><i class="fas fa-chalkboard-teacher"></i> Dashboard Dosen</h2>
    <div style="display:flex; align-items:center; gap:15px;">
        <!-- Notifikasi -->
        <div class="notif-container" onclick="toggleNotif()" style="cursor:pointer;">
            <i class="fas fa-bell" style="font-size:20px; color:#fff;"></i>
            <?php if($tugas_belum_upload > 0): ?>
                <span class="notif-badge"><?= $tugas_belum_upload ?></span>
            <?php endif; ?>
            <div class="notif-dropdown" id="notifDropdown">
                <?php
                if($tugas_belum_upload > 0){
                    mysqli_data_seek($notif_query, 0);
                    while($row_notif = mysqli_fetch_assoc($notif_query)){
                        echo "<a href='#'><i class='fas fa-tasks'></i> ".$row_notif['judul']."<br><small>Deadline: ".$row_notif['deadline']."</small></a>";
                    }
                } else {
                    echo "<a><i class='fas fa-check-circle'></i> Tidak ada tugas baru</a>";
                }
                ?>
            </div>
        </div>

        <!-- Logout -->
        <form action="logout.php" method="POST" style="margin:0;">
            <button class="logout-btn" type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </form>
    </div>
</header>

<main>
    <h3><i class="fas fa-user-graduate"></i> Selamat Datang, <?= htmlspecialchars($nama_dosen); ?> 👋</h3>

    <div class="table-container">
        <h3><i class="fas fa-tasks"></i> Daftar Tugas dari Kaprodi</h3>
        <table>
    <tr>
        <th><i class="fas fa-list-ol"></i> No</th>
        <th><i class="fas fa-book"></i> Judul</th>
        <th><i class="fas fa-tags"></i> Kategori</th>
        <th><i class="fas fa-info-circle"></i> Status</th>
        <th><i class="fas fa-align-left"></i> Deskripsi</th>
        <th><i class="fas fa-calendar-alt"></i> Deadline</th>
        <th><i class="fas fa-play-circle"></i> Aksi</th>
        <th><i class="fas fa-upload"></i> Upload Hasil</th>
    </tr>

<?php
$no = 1;

$q = mysqli_query($koneksi, "
    SELECT tugas.*, kategori_tugas.nama_kategori, status_tugas.nama_status
    FROM tugas
    LEFT JOIN kategori_tugas
        ON tugas.id_kategori = kategori_tugas.id_kategori
    LEFT JOIN status_tugas
        ON tugas.id_status = status_tugas.id_status
    WHERE tugas.dosen_id='$dosen_id'
    ORDER BY tugas.id DESC
");

if (mysqli_num_rows($q) > 0) {

    while ($row = mysqli_fetch_assoc($q)) {

        echo "<tr>
            <td>".$no++."</td>
            <td>".htmlspecialchars($row['judul'])."</td>
            <td>".htmlspecialchars($row['nama_kategori'])."</td>
            <td>".htmlspecialchars($row['nama_status'])."</td>
            <td>".htmlspecialchars($row['deskripsi'])."</td>
            <td>".htmlspecialchars($row['deadline'])."</td>

            <td>";

        // Tombol Mulai Kerjakan
        if($row['id_status'] == 1){
            echo "
                <a href='?kerjakan=".$row['id']."'
                   style='background:#f39c12;
                   color:white;
                   padding:8px 12px;
                   border-radius:8px;
                   text-decoration:none;
                   font-size:13px;'>
                   Mulai Kerjakan
                </a>
            ";
        }
        elseif($row['id_status'] == 2){
            echo "
                <span style='color:#f39c12;font-weight:bold;'>
                    Sedang Dikerjakan
                </span>
            ";
        }
        else{
            echo "
                <span style='color:#27ae60;font-weight:bold;'>
                    Selesai
                </span>
            ";
        }

        echo "</td>

            <td>
                <form method='POST' enctype='multipart/form-data'>
                    <input type='hidden' name='id' value='".$row['id']."'>
                    <input type='file' name='file' required>
                    <button type='submit'
                            name='upload'
                            class='upload-btn'>
                        <i class='fas fa-paper-plane'></i>
                        Upload
                    </button>
                </form>";

        if ($row['file_upload']) {
            echo "
                <br>
                <small>
                    File:
                    <a href='uploads/".$row['file_upload']."'
                       target='_blank'>
                        ".$row['file_upload']."
                    </a>
                </small>
            ";
        }

        echo "</td>
        </tr>";
    }

} else {

    echo "
    <tr>
        <td colspan='8'
            style='text-align:center; color:#999;'>
            Belum ada tugas dari Kaprodi
        </td>
    </tr>";
}
?>
</table>
           
    </div>
</main>

<footer>
    <p>&copy; 2025 - Sistem Manajemen Tugas Dosen | <i class="fas fa-university"></i></p>
</footer>

<script>
function toggleNotif(){
    const dropdown = document.getElementById('notifDropdown');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}
window.onclick = function(e){
    if(!e.target.closest('.notif-container')){
        document.getElementById('notifDropdown').style.display = 'none';
    }
}
</script>
</body>
</html>
