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

if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $deadline = $_POST['deadline'];
    $prioritas = $_POST['prioritas'];
    $mata_kuliah = $_POST['mata_kuliah']; // langsung nama mata kuliah

    // Simpan ke database
    $query = "INSERT INTO tugas (mahasiswa_id, mata_kuliah, judul, deskripsi, deadline, prioritas) 
              VALUES ('$mahasiswa_id', '$mata_kuliah', '$judul', '$deskripsi', '$deadline', '$prioritas')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Tugas berhasil ditambahkan!'); window.location='daftartugas.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tugas</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .form-header {
            margin-bottom: 30px;
        }

        .form-header i {
            font-size: 2.5rem;
            color: #667eea;
            margin-bottom: 10px;
        }

        .form-header h2 {
            color: #333;
            font-weight: 500;
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            z-index: 1;
        }

        input, textarea, select {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
            padding-top: 15px;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        input::placeholder {
            color: #999;
        }

        select {
            padding-left: 15px;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 15px center;
            background-repeat: no-repeat;
            background-size: 16px;
        }

        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        button:active {
            transform: translateY(0);
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 30px 20px;
                margin: 10px;
            }

            .form-header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <i class="fas fa-plus-circle"></i>
            <h2>Tambah Tugas</h2>
        </div>
        <form method="POST">
            <div class="form-group">
                <label for="mata_kuliah"><i class="fas fa-book"></i> Mata Kuliah</label>
                <input type="text" id="mata_kuliah" name="mata_kuliah" placeholder="Nama Mata Kuliah" required>
            </div>
            
            <div class="form-group">
                <label for="judul"><i class="fas fa-heading"></i> Judul Tugas</label>
                <input type="text" id="judul" name="judul" placeholder="Judul Tugas" required>
            </div>
            
            <div class="form-group">
                <label for="deskripsi"><i class="fas fa-align-left"></i> Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" placeholder="Deskripsi Tugas" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="deadline"><i class="fas fa-calendar-alt"></i> Deadline</label>
                <input type="date" id="deadline" name="deadline" required>
            </div>
            
            <div class="form-group">
                <label for="prioritas"><i class="fas fa-exclamation-triangle"></i> Prioritas</label>
                <select id="prioritas" name="prioritas" required>
                    <option value="Tinggi">Tinggi</option>
                    <option value="Sedang">Sedang</option>
                    <option value="Rendah">Rendah</option>
                </select>
            </div>
            
            <button type="submit" name="simpan">
                <i class="fas fa-save"></i> Simpan
            </button>
        </form>
    </div>
</body>
</html>
