<?php
include('dbconn.php');

// Ambil ID rekam medis yang akan dihapus
$rekam_medis_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($rekam_medis_id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Hapus data rekam medis berdasarkan ID
        $deleteQuery = "DELETE FROM rekam_medis WHERE id = '$rekam_medis_id'";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($deleteResult) {
            echo "<p>Rekam medis berhasil dihapus!</p>";
        } else {
            echo "<p>Gagal menghapus rekam medis: " . mysqli_error($conn) . "</p>";
        }
    }
} else {
    echo "<p>ID rekam medis tidak tersedia.</p>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Rekam Medis</title>
    <script>
        // Fungsi untuk konfirmasi penghapusan
        function confirmDelete() {
            return confirm("Apakah Anda yakin ingin menghapus rekam medis ini?");
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .back-button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            text-align: center;
        }

        .back-button:hover {
            background-color: #218838;
        }

        button {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Hapus Rekam Medis</h2>

    <p>Apakah Anda yakin ingin menghapus rekam medis ini?</p>
    
    <!-- Form untuk menghapus data -->
    <form method="POST" action="hapus_rekam_medis.php?id=<?= $rekam_medis_id ?>" onsubmit="return confirmDelete()">
        <button type="submit">Hapus Rekam Medis</button>
    </form>

    <a href="admin.php" class="back-button">Kembali ke Halaman Admin</a>
</div>
</body>
</html>
