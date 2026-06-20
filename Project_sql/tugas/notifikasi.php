<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// koneksi (posisi koneksi.php ada di folder config)
include __DIR__ . "/../config/koneksi.php";

// cek apakah mahasiswa sudah login
if (!isset($_SESSION['mahasiswa_id'])) {
    echo "<p>Data mahasiswa tidak ditemukan</p>";
    return;
}

$mahasiswa_id = $_SESSION['mahasiswa_id'];

// ambil semua tugas mahasiswa
$sql = mysqli_query($koneksi, 
    "SELECT * FROM tugas 
     WHERE mahasiswa_id = '$mahasiswa_id' 
     ORDER BY deadline ASC");

if (mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
        $today = strtotime(date("Y-m-d"));
        $deadline = strtotime($row['deadline']);
        $diff = ($deadline - $today) / (60 * 60 * 24);

        if ($diff < 0) {
            // lewat deadline
            echo "<div class='notif danger'>
                    ❌ Tugas <b>{$row['judul']}</b> sudah lewat deadline ({$row['deadline']}).
                  </div>";
        } elseif ($diff <= 2) {
            // 1-2 hari lagi
            echo "<div class='notif warning'>
                    ⏳ Deadline tugas <b>{$row['judul']}</b> tinggal $diff hari lagi ({$row['deadline']}).
                  </div>";
        } elseif ($diff == 3) {
            // 3 hari lagi
            echo "<div class='notif warning'>
                    ⚠ Deadline tugas <b>{$row['judul']}</b> tinggal $diff hari lagi ({$row['deadline']}).
                  </div>";
        }
    }
} else {
    echo "<p>Tidak ada tugas yang perlu dikerjakan.</p>";
}
?>