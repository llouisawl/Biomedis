<?php
include('koneksi.php'); // Pastikan koneksi database sudah benar

// Pastikan ID valid dan hanya angka yang diterima
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Menggunakan prepared statement untuk menghindari SQL Injection
    $query = "DELETE FROM appointments WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    // Memasukkan parameter ID ke dalam statement
    mysqli_stmt_bind_param($stmt, 'i', $id);

    // Menjalankan statement
    if (mysqli_stmt_execute($stmt)) {
        echo "Antrian berhasil dihapus!";
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($conn);
    }

    // Menutup statement
    mysqli_stmt_close($stmt);
} else {
    echo "ID tidak valid!";
}

mysqli_close($conn); // Pastikan koneksi database ditutup setelah selesai
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Antrian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            text-align: center;
            font-size: 16px;
        }

        .btn-back {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }

        a {
            display: inline-block;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hapus Antrian</h1>
        <p>Apakah Anda yakin ingin menghapus antrian ini?</p>
        <a href="admin.php" class="btn-back">Kembali ke Beranda</a>
    </div>
</body>
</html>
