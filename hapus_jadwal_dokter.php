<?php
// Mulai sesi
session_start();

// Masukkan koneksi ke database
include('dbconn.php');

// Mengecek apakah ID disediakan
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data dokter untuk ditampilkan
    $query = "SELECT * FROM dokter WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    // Periksa apakah data dokter ditemukan
    if (mysqli_num_rows($result) > 0) {
        $dokter = mysqli_fetch_assoc($result);

        // Jika konfirmasi penghapusan diterima
        if (isset($_POST['confirm'])) {
            $sql = "DELETE FROM dokter WHERE id = '$id'";
            if ($conn->query($sql) === TRUE) {
                header("Location: admin.php?message=Dokter berhasil dihapus!");
                exit();
            } else {
                $message = "Terjadi kesalahan: " . $conn->error;
            }
        }
    } else {
        $message = "Data dokter tidak ditemukan!";
    }
} else {
    $message = "ID dokter tidak disediakan!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Dokter</title>
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
            text-align: center;
        }

        h1 {
            color: #333;
        }

        p {
            font-size: 16px;
            margin: 10px 0;
        }

        .dokter-details {
            margin-bottom: 20px;
            text-align: left;
        }

        .dokter-details p {
            font-size: 14px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            margin: 10px 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"] {
            background-color: #e74c3c;
            color: white;
        }

        button[type="button"] {
            background-color: #95a5a6;
            color: white;
        }

        button:hover {
            opacity: 0.9;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            font-size: 16px;
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Hapus Dokter</h1>
    <?php if (isset($dokter)): ?>
        <p>Apakah Anda yakin ingin menghapus dokter berikut?</p>
        <div class="dokter-details">
            <p><strong>Nama:</strong> <?php echo $dokter['name']; ?></p>
            <p><strong>Hari:</strong> <?php echo $dokter['hari']; ?></p>
            <p><strong>Jam:</strong> <?php echo $dokter['jam']; ?></p>
            <p><strong>Lokasi:</strong> <?php echo $dokter['Lokasi']; ?></p>
        </div>
        <form method="post">
            <button type="submit" name="confirm">Ya, Hapus</button>
            <a href="admin.php"><button type="button">Batal</button></a>
        </form>
    <?php else: ?>
        <p><?php echo $message; ?></p>
        <a href="admin.php">Kembali ke Halaman Admin</a>
    <?php endif; ?>
</div>
</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>
