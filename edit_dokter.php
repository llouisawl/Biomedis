<?php
include('dbconn.php');

// Pastikan ID dokter ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data dokter berdasarkan ID
    $query = "SELECT * FROM dokterinfo WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $dokter = mysqli_fetch_assoc($result);
    } else {
        echo "Dokter tidak ditemukan.";
        exit;
    }
} else {
    echo "ID dokter tidak tersedia.";
    exit;
}

// Proses ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Menangkap data dari form
    $nama = $_POST['nama'];
    $spesialis = $_POST['spesialis'];
    $profil = $_POST['profil'];
    $kontak_email = $_POST['kontak_email'];
    $kontak_telepon = $_POST['kontak_telepon'];

    // Proses upload gambar, jika ada gambar baru yang diupload
    $gambar = $_FILES['gambar']['name'];
    if ($gambar) {
        $gambarTmp = $_FILES['gambar']['tmp_name'];
        $gambarPath = 'images/' . $gambar;
        move_uploaded_file($gambarTmp, $gambarPath);
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $gambar = $dokter['gambar'];
    }

    // Menyimpan jadwal dalam format "Hari|Jam Mulai|Jam Selesai|Lokasi"
    $jadwal = [];
    foreach ($_POST['hari'] as $index => $hari) {
        $jam_mulai = $_POST['jam_mulai'][$index];
        $jam_selesai = $_POST['jam_selesai'][$index];
        $lokasi = $_POST['lokasi'][$index];
        $jadwal[] = "{$hari}|{$jam_mulai}|{$jam_selesai}|{$lokasi}";
    }
    $jadwal = implode("\n", $jadwal); // Menggabungkan jadwal dengan newline sebagai pemisah

    // Query untuk memperbarui data dokter
    $query = "UPDATE dokterinfo SET 
                nama = '$nama', 
                spesialis = '$spesialis', 
                gambar = '$gambar', 
                profil = '$profil', 
                jadwal = '$jadwal', 
                kontak_email = '$kontak_email', 
                kontak_telepon = '$kontak_telepon' 
              WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "Dokter berhasil diperbarui!";
        header('Location: admin.php'); // Redirect ke halaman admin dokter setelah berhasil
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dokter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 150vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"],
        input[type="file"],
        input[type="email"],
        input[type="time"],
        textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="file"]:focus,
        input[type="email"]:focus,
        input[type="time"]:focus,
        textarea:focus {
            border-color: #007BFF;
            outline: none;
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

        .jadwal-container {
            margin-top: 10px;
        }

        .jadwal-item {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Dokter</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="nama">Nama Dokter:</label>
            <input type="text" name="nama" id="nama" value="<?php echo $dokter['nama']; ?>" required><br>

            <label for="spesialis">Spesialis:</label>
            <select name="spesialis" required>
                <option value="Mata" <?php if ($dokter['spesialis'] == 'Mata') echo 'selected'; ?>>Mata</option>
                <option value="Anak" <?php if ($dokter['spesialis'] == 'Anak') echo 'selected'; ?>>Anak</option>
                <option value="Kandungan" <?php if ($dokter['spesialis'] == 'Kandungan') echo 'selected'; ?>>Kandungan</option>
                <option value="Penyakit Dalam" <?php if ($dokter['spesialis'] == 'Penyakit Dalam') echo 'selected'; ?>>Penyakit Dalam</option>
                <option value="Gigi" <?php if ($dokter['spesialis'] == 'Gigi') echo 'selected'; ?>>Gigi</option>
                <option value="Jantung" <?php if ($dokter['spesialis'] == 'Jantung') echo 'selected'; ?>>Jantung</option>
                <option value="Kulit" <?php if ($dokter['spesialis'] == 'Kulit') echo 'selected'; ?>>Kulit</option>
                <option value="THT" <?php if ($dokter['spesialis'] == 'THT') echo 'selected'; ?>>THT</option>
            </select><br>

            <label for="gambar">Gambar Dokter:</label>
            <input type="file" name="gambar" id="gambar"><br>
            <img src="images/<?php echo $dokter['gambar']; ?>" alt="Gambar Dokter" width="100"><br>

            <label for="profil">Profil Dokter:</label>
            <textarea name="profil" id="profil" required><?php echo $dokter['profil']; ?></textarea><br>

            <label for="kontak_email">Email Dokter:</label>
            <input type="email" name="kontak_email" id="kontak_email" value="<?php echo $dokter['kontak_email']; ?>" required><br>

            <label for="kontak_telepon">Telepon Dokter:</label>
            <input type="text" name="kontak_telepon" id="kontak_telepon" value="<?php echo $dokter['kontak_telepon']; ?>" required><br>

            <label for="jadwal">Jadwal Praktik:</label>
            <div class="jadwal-container">
                <?php
                $jadwalArray = explode("\n", $dokter['jadwal']);
                foreach ($jadwalArray as $index => $item) {
                    list($hari, $jam_mulai, $jam_selesai, $lokasi) = explode('|', $item);
                ?>
                    <div class="jadwal-item">
                        <label for="hari">Hari:</label>
                        <select name="hari[]" required>
                            <option value="Senin" <?php if ($hari == 'Senin') echo 'selected'; ?>>Senin</option>
                            <option value="Selasa" <?php if ($hari == 'Selasa') echo 'selected'; ?>>Selasa</option>
                            <option value="Rabu" <?php if ($hari == 'Rabu') echo 'selected'; ?>>Rabu</option>
                            <option value="Kamis" <?php if ($hari == 'Kamis') echo 'selected'; ?>>Kamis</option>
                            <option value="Jumat" <?php if ($hari == 'Jumat') echo 'selected'; ?>>Jumat</option>
                        </select><br>

                        <label for="jam_mulai">Jam Mulai:</label>
                        <input type="time" name="jam_mulai[]" value="<?php echo $jam_mulai; ?>" required><br>

                        <label for="jam_selesai">Jam Selesai:</label>
                        <input type="time" name="jam_selesai[]" value="<?php echo $jam_selesai; ?>" required><br>

                        <label for="lokasi">Lokasi:</label>
                        <input type="text" name="lokasi[]" value="<?php echo $lokasi; ?>" required><br>
                    </div>
                <?php } ?>
                <button type="button" onclick="tambahJadwal()">Tambah Jadwal</button>
            </div>

            <button type="submit">Perbarui Dokter</button>
        </form>

        <a href="admin.php" class="back-btn">Kembali ke Halaman Admin</a>
        <div class="form-footer">
            <p>&copy; 2024 Biomedis</p>
        </div>
    </div>

    <script>
        function tambahJadwal() {
            var jadwalContainer = document.querySelector('.jadwal-container');
            var jadwalItem = document.querySelector('.jadwal-item').cloneNode(true);
            jadwalContainer.appendChild(jadwalItem);
        }
    </script>
</body>
</html>
