<?php
session_start();
include('dbconn.php');

$message = "";

// Periksa apakah ID berita disediakan
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data berita untuk ditampilkan
    $sql = "SELECT * FROM berita WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $berita = $result->fetch_assoc();

        // Proses penghapusan berita jika tombol konfirmasi ditekan
        if (isset($_POST['confirm'])) {
            $sql = "DELETE FROM berita WHERE id = '$id'";

            if ($conn->query($sql) === TRUE) {
                header("Location: admin.php?message=Berita berhasil dihapus!");
                exit();
            } else {
                $message = "Terjadi kesalahan: " . $conn->error;
            }
        }
    } else {
        $message = "Berita tidak ditemukan!";
    }
} else {
    $message = "ID berita tidak disediakan!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Berita</title>
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
    <h1>Hapus Berita</h1>
    <?php if (isset($message)) echo "<p style='color: red;'>$message</p>"; ?>

    <?php if (isset($berita)): ?>
        <p>Apakah Anda yakin ingin menghapus berita dengan judul: <strong><?php echo $berita['judul']; ?></strong>?</p>
        <form action="hapus_berita.php?id=<?php echo $berita['id']; ?>" method="POST">
            <button type="submit" name="confirm">Ya, Hapus Berita</button>
        </form>
    <?php else: ?>
        <p>Berita tidak ditemukan untuk dihapus.</p>
    <?php endif; ?>

    <a href="admin.php"><button class="btn-back">Kembali ke Halaman Admin</button></a>
</div>
</body>
</html>

<?php $conn->close(); ?>
