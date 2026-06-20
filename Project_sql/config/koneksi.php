<?php
$koneksi = mysqli_connect("localhost", "root", "", "manajemen_tugas2");

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit;
}
?>
