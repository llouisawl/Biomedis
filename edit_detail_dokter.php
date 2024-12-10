<?php
include('dbconn.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data dokter berdasarkan ID
    $query = "SELECT * FROM dokterinfo WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $dokter = $result->fetch_assoc();
    } else {
        echo "Dokter tidak ditemukan.";
        exit;
    }

    // Jika form disubmit, update data dokter
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama = $_POST['nama'];
        $spesialis = $_POST['spesialis'];
        $profil = $_POST['profil'];
        $jadwal = $_POST['jadwal'];
        $kontak_email = $_POST['kontak_email'];
        $kontak_telepon = $_POST['kontak_telepon'];

        // Update gambar jika ada file gambar baru
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $gambarName = $_FILES['gambar']['name'];
            $gambarTmp = $_FILES['gambar']['tmp_name'];
            $uploadDir = 'images/';
            $gambarPath = $uploadDir . basename($gambarName);

            if (move_uploaded_file($gambarTmp, $gambarPath)) {
                $gambar = basename($gambarName);
            } else {
                $gambar = $dokter['gambar']; // Jika gagal upload gambar baru, gunakan gambar lama
            }
        } else {
            $gambar = $dokter['gambar']; // Jika tidak ada gambar baru, tetap gunakan gambar lama
        }

        // Update data dokter
        $query = "UPDATE dokterinfo SET nama = ?, spesialis = ?, gambar = ?, profil = ?, jadwal = ?, kontak_email = ?, kontak_telepon = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssssssi', $nama, $spesialis, $gambar, $profil, $jadwal, $kontak_email, $kontak_telepon, $id);
        $stmt->execute();

        // Redirect setelah berhasil update
        header('Location: admin.php'); 
        exit;
    }
} else {
    echo "ID tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Detail Dokter</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 150vh;
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
        input[type="text"], textarea, input[type="file"], input[type="email"], input[type="tel"], select {
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
        <h2>Edit Detail Dokter</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="nama" value="<?= htmlspecialchars($dokter['nama']) ?>" required>
            
            <label for="spesialis">Spesialis:</label>
            <select name="spesialis" required>
                <option value="Mata" <?= $dokter['spesialis'] == 'Mata' ? 'selected' : '' ?>>Mata</option>
                <option value="Anak" <?= $dokter['spesialis'] == 'Anak' ? 'selected' : '' ?>>Anak</option>
                <option value="Kandungan" <?= $dokter['spesialis'] == 'Kandungan' ? 'selected' : '' ?>>Kandungan</option>
                <option value="Penyakit Dalam" <?= $dokter['spesialis'] == 'Penyakit Dalam' ? 'selected' : '' ?>>Penyakit Dalam</option>
                <option value="Gigi" <?= $dokter['spesialis'] == 'Gigi' ? 'selected' : '' ?>>Gigi</option>
                <option value="Jantung" <?= $dokter['spesialis'] == 'Jantung' ? 'selected' : '' ?>>Jantung</option>
                <option value="Kulit" <?= $dokter['spesialis'] == 'Kulit' ? 'selected' : '' ?>>Kulit</option>
                <option value="THT" <?= $dokter['spesialis'] == 'THT' ? 'selected' : '' ?>>THT</option>
            </select>

            <input type="file" name="gambar" accept="image/*">
            <textarea name="profil" required><?= htmlspecialchars($dokter['profil']) ?></textarea>
            <textarea name="jadwal" required><?= htmlspecialchars($dokter['jadwal']) ?></textarea>
            <input type="email" name="kontak_email" value="<?= htmlspecialchars($dokter['kontak_email']) ?>" required>
            <input type="tel" name="kontak_telepon" value="<?= htmlspecialchars($dokter['kontak_telepon']) ?>" required>

            <button type="submit">Simpan Perubahan</button>
        </form>
        <a href="admin.php" class="back-btn">Kembali ke Halaman Admin</a>
        <div class="form-footer">
            <p>&copy; 2024 Biomedis</p>
        </div>
    </div>

</body>
</html>
