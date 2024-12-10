<?php
session_start();
include('dbconn.php');

$message = "";

// Periksa apakah ID dokter disediakan
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Gunakan prepared statement untuk mengambil data dokter berdasarkan ID
    $sql = "SELECT * FROM dokterinfo WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $dokter = $result->fetch_assoc();

        // Proses penghapusan dokter jika tombol konfirmasi ditekan
        if (isset($_POST['confirm'])) {
            // Hapus data di tabel poli_dokter yang mengacu pada dokter ini
            $sql = "DELETE FROM poli_dokter WHERE dokter_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();

            // Hapus dokter setelah data terkait di poli_dokter dihapus
            $sql = "DELETE FROM dokterinfo WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header("Location: admin.php?message=Dokter berhasil dihapus!");
                exit();
            } else {
                $message = "Terjadi kesalahan: Tidak ada perubahan yang terjadi.";
            }
        }
    } else {
        $message = "Dokter tidak ditemukan!";
    }
} else {
    $message = "ID dokter tidak disediakan!";
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Dokter</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 0; }
        .container { width: 50%; margin: 50px auto; background-color: #fff; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px; }
        h1 { text-align: center; color: #333; margin-bottom: 20px; }
        button { padding: 10px; background-color: #007BFF; color: white; font-size: 16px; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s; }
        button:hover { background-color: #0056b3; }
        .btn-back { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; text-align: center; margin-top: 20px; }
        .btn-back:hover { background-color: #45a049; }
    </style>
</head>
<body>
<div class="container">
    <h1>Hapus Dokter</h1>
    <?php if (isset($message)) echo "<p style='color: red;'>$message</p>"; ?>

    <?php if (isset($dokter)): ?>
        <p>Apakah Anda yakin ingin menghapus dokter dengan nama: <strong><?php echo htmlspecialchars($dokter['nama']); ?></strong>?</p>
        <form action="hapus_dokter.php?id=<?php echo $dokter['id']; ?>" method="POST">
            <button type="submit" name="confirm">Ya, Hapus Dokter</button>
        </form>
    <?php else: ?>
        <p>Dokter tidak ditemukan untuk dihapus.</p>
    <?php endif; ?>

    <a href="admin.php"><button class="btn-back">Kembali ke Halaman Admin</button></a>
</div>
</body>
</html>

<?php $conn->close(); ?>
