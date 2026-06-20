<?php
session_start();
include 'config/koneksi.php';

// Cek login
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'kaprodi') {
    header("Location: login.php");
    exit;
}

// Tambah tugas
if (isset($_POST['tambah'])) {
    $dosen_id = $_POST['dosen_id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $deadline = $_POST['deadline'];
    $id_kategori = $_POST['id_kategori'];
    $id_status = $_POST['id_status'];

    // Ambil nama dosen
    $dosen = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT nama FROM user WHERE id='$dosen_id'"));
    $nama_dosen = $dosen['nama'];

    $sql = "INSERT INTO tugas (dosen_id,nama_dosen,judul,deskripsi,deadline,id_kategori,id_status)
VALUES('$dosen_id','$nama_dosen','$judul','$deskripsi','$deadline','$id_kategori','1')";
    if (mysqli_query($koneksi, $sql)) {
        $_SESSION['notif'] = "Tugas berhasil ditambahkan!";
    } else {
        $_SESSION['notif'] = "Gagal menambahkan tugas!";
    }
    header("Location: kaprodi_dashboard.php");
    exit;
}

// Edit tugas
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $dosen_id = $_POST['dosen_id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $deadline = $_POST['deadline'];
    $id_kategori = $_POST['id_kategori'];
    

    $dosen = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT nama FROM user WHERE id='$dosen_id'"));
    $nama_dosen = $dosen['nama'];

    if (mysqli_query($koneksi, "UPDATE tugas SET dosen_id='$dosen_id', nama_dosen='$nama_dosen', judul='$judul', deskripsi='$deskripsi', deadline='$deadline', id_kategori='$id_kategori' WHERE id='$id'")) {
        $_SESSION['notif'] = "Tugas berhasil diperbarui!";
    } else {
        $_SESSION['notif'] = "Gagal memperbarui tugas!";
    }
    header("Location: kaprodi_dashboard.php");
    exit;
}

// Hapus tugas
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if (mysqli_query($koneksi, "DELETE FROM tugas WHERE id='$id'")) {
        $_SESSION['notif'] = "Tugas berhasil dihapus!";
    } else {
        $_SESSION['notif'] = "Gagal menghapus tugas!";
    }
    header("Location: kaprodi_dashboard.php");
    exit;
}

$total_tugas = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tugas"));

$belum = mysqli_num_rows(mysqli_query($koneksi,
"SELECT * FROM tugas WHERE id_status='1'"));

$sedang = mysqli_num_rows(mysqli_query($koneksi,
"SELECT * FROM tugas WHERE id_status='2'"));

$selesai = mysqli_num_rows(mysqli_query($koneksi,
"SELECT * FROM tugas WHERE id_status='3'"));

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Kaprodi</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #f4f6f9;
    color: #333;
    margin: 0;
    padding: 0;
    min-height: 100vh;
}

/* HEADER */
header {
    background: #2c3e50;
    color: white;
    padding: 20px 35px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

header h2 {
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
}

.logout-btn {
    background: #e74c3c;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    transition: 0.3s;
}

.logout-btn:hover {
    background: #c0392b;
}

/* MAIN */
main {
    padding: 30px;
}

/* CARD */
.form-container,
.table-container {
    background: white;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

h3 {
    margin-top: 0;
    margin-bottom: 20px;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* FORM */
input,
textarea,
select {
    width: 100%;
    padding: 12px;
    margin-bottom: 12px;
    border: 1px solid #dcdde1;
    border-radius: 8px;
    box-sizing: border-box;
    font-family: inherit;
    font-size: 14px;
    background: white;
}

input:focus,
textarea:focus,
select:focus {
    outline: none;
    border-color: #3498db;
}

/* BUTTON */
button {
    background: #3498db;
    color: white;
    border: none;
    padding: 11px 18px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    transition: 0.3s;
}

button:hover {
    background: #2980b9;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #34495e;
    color: white;
    padding: 12px;
}

td {
    padding: 12px;
    border-bottom: 1px solid #ecf0f1;
}

tr:hover {
    background: #f8f9fa;
}

/* LINK */
a {
    color: #3498db;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

.hapus-btn {
    color: #e74c3c;
    font-weight: 600;
}

.hapus-btn:hover {
    color: #c0392b;
}

/* STATUS */
.notif {
    color: #27ae60;
    font-weight: 600;
}

.notif-belum {
    color: #f39c12;
    font-weight: 600;
}

/* TOAST */
.toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #27ae60;
    color: white;
    padding: 14px 22px;
    border-radius: 8px;
    font-weight: 500;
    z-index: 9999;
    animation: fadeInOut 4s ease forwards;
}

@keyframes fadeInOut {
    0% {
        opacity: 0;
        transform: translateY(-20px);
    }
    10% {
        opacity: 1;
        transform: translateY(0);
    }
    90% {
        opacity: 1;
    }
    100% {
        opacity: 0;
        transform: translateY(-20px);
    }
}

/* MODAL */
#editModal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 9999;
}

#editModal .modal-content{
    background: #ffffff;
    color: #2d3436;
    padding: 30px;
    border-radius: 18px;
    width: 450px;
    max-height: 85vh;
    overflow-y: auto;
    margin: 50px auto;
    box-shadow: 0 15px 40px rgba(0,0,0,0.25);
    border-top: 5px solid #0984e3;
}

#editModal h3 {
    text-align: center;
    color: #2c3e50;
}

#editModal label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

#editModal input,
#editModal textarea,
#editModal select {
    margin-bottom: 15px;
}

#editModal .button-group {
    display: flex;
    justify-content: center;
    gap: 10px;
}

#editModal button[name="edit"] {
    background: #3498db;
}

#editModal button[name="edit"]:hover {
    background: #2980b9;
}

#editModal button[type="button"] {
    background: #95a5a6;
}

#editModal button[type="button"]:hover {
    background: #7f8c8d;
}

/* FOOTER */
footer {
    text-align: center;
    padding: 15px;
    color: #7f8c8d;
}
.stats-container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:30px;
}

.stat-card{
    background:white;
    padding:25px;
    border-radius:12px;
    text-align:center;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

.stat-card i{
    font-size:35px;
    margin-bottom:10px;
}

.stat-card h2{
    margin:10px 0;
    font-size:28px;
}

.stat-card.total{
    border-top:4px solid #3498db;
}

.stat-card.belum{
    border-top:4px solid #f39c12;
}

.stat-card.sedang{
    border-top:4px solid #9b59b6;
}

.stat-card.selesai{
    border-top:4px solid #27ae60;
}


</style>
</head>
<body>
<header>
    <h2><i class="fas fa-user-shield"></i> Dashboard Kaprodi</h2>
    <form action="logout.php" method="POST" style="margin:0;">
        <button class="logout-btn" type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </form>
</header>

<main>
    <h3><i class="fas fa-hand-sparkles"></i> Selamat Datang, <?= $_SESSION['nama']; ?> 👋</h3>
    <div class="stats-container">

    <div class="stat-card total">
        <i class="fas fa-tasks"></i>
        <h2><?= $total_tugas ?></h2>
        <p>Total Tugas</p>
    </div>

    <div class="stat-card belum">
        <i class="fas fa-clock"></i>
        <h2><?= $belum ?></h2>
        <p>Belum Dikerjakan</p>
    </div>

    <div class="stat-card sedang">
        <i class="fas fa-spinner"></i>
        <h2><?= $sedang ?></h2>
        <p>Sedang Dikerjakan</p>
    </div>

    <div class="stat-card selesai">
        <i class="fas fa-check-circle"></i>
        <h2><?= $selesai ?></h2>
        <p>Selesai</p>
    </div>

</div>

    <!-- Tambah Tugas -->
    <div class="form-container">
        <h3><i class="fas fa-tasks"></i> Tambah Tugas untuk Dosen</h3>
        <form method="POST">
            <select name="dosen_id" required>
                <option value="">-- Pilih Dosen --</option>
                <?php
                $q_dosen = mysqli_query($koneksi, "SELECT id, nama FROM user WHERE role='dosen'");
                while($d = mysqli_fetch_assoc($q_dosen)) {
                    echo "<option value='".$d['id']."'>".$d['nama']."</option>";
                }
                ?>
            </select>
            <input type="text" name="judul" placeholder="Judul Tugas" required>

        <textarea name="deskripsi" rows="4" placeholder="Deskripsi Tugas..." required></textarea>

        <input type="date" name="deadline" required>

    <select name="id_kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <option value="1">Akademik</option>
        <option value="2">Administrasi</option>
        <option value="3">Penelitian</option>
        <option value="4">Pengabdian</option>
    </select>

    <button type="submit" name="tambah">
        <i class="fas fa-plus-circle"></i> Tambah Tugas
    </button>
        </form>
    </div>

    <!-- Daftar Semua Tugas -->
    <div class="table-container">
        <h3><i class="fas fa-list-check"></i> Daftar Semua Tugas</h3>
        <table>
            <tr>
                <th>No</th>
                <th>Dosen</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Deadline</th>
                <th>Status Upload</th>
                <th>Aksi</th>
            </tr>
            <?php
            $no=1;
            $q = mysqli_query($koneksi,"SELECT * FROM tugas ORDER BY id DESC");
            if(mysqli_num_rows($q)>0){
                while($row=mysqli_fetch_assoc($q)){
                    echo "<tr>
                    <td>".$no++."</td>
                    <td><i class='fas fa-user-tie'></i> ".$row['nama_dosen']."</td>
                    <td><i class='fas fa-file-alt'></i> ".$row['judul']."</td>
                    <td>".$row['deskripsi']."</td>
                    <td><i class='fas fa-calendar'></i> ".$row['deadline']."</td>
                    <td>";
                    if($row['file_upload']){
                        echo "<span class='notif'>✅ Sudah Upload</span><br><a href='uploads/".$row['file_upload']."' target='_blank'>".$row['file_upload']."</a>";
                    }else{
                        echo "<span class='notif-belum'>⏳ Belum Upload</span>";
                    }
                    echo "</td>
                    <td>
                        <a href='#' onclick='editTugas(".$row['id'].",".$row['dosen_id'].",`".$row['judul']."`,`".$row['deskripsi']."`,`".$row['deadline']."`)'><i class='fas fa-edit'></i></a> |
                        <a href='?hapus=".$row['id']."' class='hapus-btn' onclick='return confirm(\"Hapus tugas ini?\")'><i class='fas fa-trash'></i></a>
                    </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7' style='text-align:center;'>Belum ada tugas</td></tr>";
            }
            ?>
        </table>
    </div>
</main>

<!-- Modal Edit -->
<div id="editModal">
    <div class="modal-content">
        <h3><i class="fas fa-pen-to-square"></i> Edit Tugas</h3>
        <form method="POST">
            <input type="hidden" id="editId" name="id">
            
            <label>Dosen</label>
            <select name="dosen_id" id="editDosen" required>
                <option value="">-- Pilih Dosen --</option>
                <?php
                $q_dosen = mysqli_query($koneksi, "SELECT id, nama FROM user WHERE role='dosen'");
                while($d = mysqli_fetch_assoc($q_dosen)) {
                    echo "<option value='".$d['id']."'>".$d['nama']."</option>";
                }
                ?>
            </select>

            <label>Judul</label>
            <input type="text" id="editJudul" name="judul" required>

            <label>Deskripsi</label>
            <textarea id="editDeskripsi" name="deskripsi" rows="3" required></textarea>

            <label>Deadline</label>
            <input type="date" id="editDeadline" name="deadline" required>
            
            <label>Deadline</label>
            <input type="date" id="editDeadline" name="deadline" required>

            <label>Kategori</label>
            <select name="id_kategori" id="editKategori" required>
                 <?php
                $kategori = mysqli_query($koneksi, "SELECT * FROM kategori_tugas");
                while($k = mysqli_fetch_assoc($kategori)){
                 echo "<option value='".$k['id_kategori']."'>".$k['nama_kategori']."</option>";
                }
                ?>
            </select>

            <div class="button-group">

            <div class="button-group">
                <button type="submit" name="edit"><i class="fas fa-save"></i> Simpan</button>
                <button type="button" onclick="closeModal()"><i class="fas fa-times"></i> Batal</button>
            </div>
        </form>
    </div>
</div>


<?php if(isset($_SESSION['notif'])): ?>
<div class="toast"><?= $_SESSION['notif'] ?></div>
<script>
setTimeout(()=>{document.querySelector('.toast').style.display='none';},4000);
</script>
<?php unset($_SESSION['notif']); endif; ?>

<script>
function editTugas(id, dosen_id, judul, deskripsi, deadline){
    document.getElementById('editId').value=id;
    document.getElementById('editDosen').value=dosen_id;
    document.getElementById('editJudul').value=judul;
    document.getElementById('editDeskripsi').value=deskripsi;
    document.getElementById('editDeadline').value=deadline;
    document.getElementById('editModal').style.display='block';
}
function closeModal(){
    document.getElementById('editModal').style.display='none';
}
</script>

<footer>
<p>&copy; 2025 - Sistem Manajemen Tugas Kaprodi | <i class="fas fa-university"></i></p>
</footer>
</body>
</html>
