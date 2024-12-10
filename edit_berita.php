<?php
include('dbconn.php');

$id = $_GET['id'];
$query = "SELECT * FROM berita WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $konten = $_POST['konten'];
    $link = $_POST['link'];

    // Cek apakah gambar diunggah
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambarName = $_FILES['gambar']['name'];
        $gambarTmp = $_FILES['gambar']['tmp_name'];
        $uploadDir = 'images/';
        $gambarPath = $uploadDir . basename($gambarName);

        if (move_uploaded_file($gambarTmp, $gambarPath)) {
            // Hapus gambar lama
            if (file_exists("images/" . $row['gambar'])) {
                unlink("images/" . $row['gambar']);
            }
            $gambar = basename($gambarName);
        }
    } else {
        $gambar = $row['gambar'];
    }

    $query = "UPDATE berita SET judul = ?, konten = ?, gambar = ?, link = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssi', $judul, $konten, $gambar, $link, $id);
    $stmt->execute();

    header('Location: admin.php');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 600px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .form-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        input[type="text"], textarea, input[type="file"] {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
            background-color: #f9f9f9;
        }
        textarea {
            resize: vertical;
            height: 150px;
        }
        button {
            width: 100%;
            padding: 14px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .back-btn {
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            transition: background-color 0.3s;
        }
        .back-btn:hover {
            background-color: #218838;
        }
        .form-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Edit Berita</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="judul" value="<?= htmlspecialchars($row['judul']) ?>" required>
            <textarea name="konten" required><?= htmlspecialchars($row['konten']) ?></textarea>
            <input type="text" name="link" value="<?= htmlspecialchars($row['link']) ?>" placeholder="Link Sumber">
            <input type="file" name="gambar" accept="image/*">
            <button type="submit">Simpan Perubahan</button>
        </form>
        <!-- Tombol Kembali ke Admin -->
        <a href="admin.php" class="back-btn">Kembali ke Halaman Admin</a>
        <div class="form-footer">
            <p>&copy; 2024 Biomedis</p>
        </div>
    </div>

</body>
</html>
