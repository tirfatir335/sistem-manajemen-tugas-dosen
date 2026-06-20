<?php
session_start();
include "../config/koneksi.php";

// Cek login
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil data mahasiswa dari session
$nama = $_SESSION['user'];
$q_mhs = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE nama='$nama' LIMIT 1");
$mhs = mysqli_fetch_assoc($q_mhs);
$mahasiswa_id = $mhs['id'];

// Ambil ID tugas
$id = $_GET['id'];

// Hapus tugas (pastikan milik mahasiswa ini)
$delete = mysqli_query($koneksi, "
    DELETE FROM tugas 
    WHERE id='$id' AND mahasiswa_id='$mahasiswa_id'
");

if ($delete) {
    echo "<script>alert('Tugas berhasil dihapus!'); window.location='daftartugas.php';</script>";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>