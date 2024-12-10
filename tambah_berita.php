<?php
include('dbconn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $konten = $_POST['konten'];
    $link = $_POST['link'];

    // Upload gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambarName = $_FILES['gambar']['name'];
        $gambarTmp = $_FILES['gambar']['tmp_name'];
        $uploadDir = 'images/';
        $gambarPath = $uploadDir . basename($gambarName);

        if (move_uploaded_file($gambarTmp, $gambarPath)) {
            $gambar = basename($gambarName);
        } else {
            $gambar = '';
        }
    } else {
        $gambar = '';
    }

    $query = "INSERT INTO berita (judul, konten, gambar, link) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssss', $judul, $konten, $gambar, $link);
    $stmt->execute();

    header('Location: admin.php');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 500px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        input[type="text"], textarea, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
            height: 150px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        input[type="file"] {
            background-color: #f8f8f8;
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
            display: inline-block;
            text-align: center;
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
        <h2>Tambah Berita</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="judul" placeholder="Judul Berita" required>
            <textarea name="konten" placeholder="Konten Berita" required></textarea>
            <input type="text" name="link" placeholder="Link Sumber">
            <input type="file" name="gambar" accept="image/*" required>
            <button type="submit">Tambah Berita</button>
        </form>
        <!-- Tombol Kembali ke Admin di tengah -->
        <a href="admin.php" class="back-btn">Kembali ke Halaman Admin</a>
        <div class="form-footer">
            <p>&copy; 2024 Biomedis</p>
        </div>
    </div>

</body>
</html>


