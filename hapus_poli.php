<?php
// Koneksi ke database
include('dbconn.php');

// Cek apakah ada id poli yang dikirimkan
if (isset($_GET['id'])) {
    $poli_id = $_GET['id'];

    // Query untuk mengambil data poli berdasarkan ID
    $query_poli = "SELECT * FROM poli WHERE id = '$poli_id'";
    $result_poli = mysqli_query($conn, $query_poli);

    if (mysqli_num_rows($result_poli) > 0) {
        $poli = mysqli_fetch_assoc($result_poli);
    } else {
        echo "Poli tidak ditemukan.";
        exit();
    }

    // Proses hapus jika tombol konfirmasi diklik
    if (isset($_POST['hapus'])) {
        // Menghapus data dokter yang terkait dengan poli
        $query_dokter = "DELETE FROM poli_dokter WHERE poli_id = '$poli_id'";
        if (!mysqli_query($conn, $query_dokter)) {
            echo "Error: " . $query_dokter . "<br>" . mysqli_error($conn);
        }

        // Menghapus data poli
        $query_poli_delete = "DELETE FROM poli WHERE id = '$poli_id'";
        if (mysqli_query($conn, $query_poli_delete)) {
            echo "Poli berhasil dihapus!";
            header("Location: admin.php"); // Redirect ke halaman admin setelah penghapusan
            exit();
        } else {
            echo "Error: " . $query_poli_delete . "<br>" . mysqli_error($conn);
        }
    }
} else {
    echo "ID poli tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Poli</title>

    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Gaya CSS tambahan untuk penataan -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        label {
            font-weight: bold;
        }
        .btn-submit, .btn-back {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }
        .btn-submit {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-submit:hover {
            background-color: #c82333;
        }
        .btn-back {
            background-color: #6c757d;
            color: #fff;
            margin-top: 10px;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hapus Poli</h2>
        
        <!-- Konfirmasi Penghapusan Poli -->
        <form action="hapus_poli.php?id=<?= $poli_id; ?>" method="POST">
            <div class="form-group">
                <label for="nama_poli">Nama Poli:</label>
                <input type="text" class="form-control" value="<?= $poli['nama_poli']; ?>" disabled>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea class="form-control" rows="4" disabled><?= $poli['description']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="spesialis">Spesialisasi:</label>
                <input type="text" class="form-control" value="<?= $poli['spesialis']; ?>" disabled>
            </div>

            <p>Apakah Anda yakin ingin menghapus poli ini?</p>
            
            <!-- Tombol konfirmasi -->
            <button type="submit" name="hapus" class="btn-submit">Hapus Poli</button>
        </form>

        <!-- Tombol Kembali ke Halaman Admin -->
        <a href="admin.php">
            <button class="btn-back">Kembali ke Halaman Admin</button>
        </a>
    </div>
</body>
</html>
