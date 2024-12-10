<?php
// Koneksi ke database
include('dbconn.php');

// Periksa apakah ada ID poli yang diterima untuk diedit
if (isset($_GET['id'])) {
    $poli_id = $_GET['id'];

    // Ambil data poli yang ingin diedit
    $query = "SELECT * FROM poli WHERE id = '$poli_id'";
    $result = mysqli_query($conn, $query);
    $poli = mysqli_fetch_assoc($result);

    // Jika poli tidak ditemukan
    if (!$poli) {
        echo "Poli tidak ditemukan!";
        exit;
    }

    // Ambil dokter yang sudah terhubung dengan poli ini
    $query_dokter = "SELECT dokter_id FROM poli_dokter WHERE poli_id = '$poli_id'";
    $result_dokter = mysqli_query($conn, $query_dokter);
    $dokter_ids = [];
    while ($dokter = mysqli_fetch_assoc($result_dokter)) {
        $dokter_ids[] = $dokter['dokter_id'];
    }

    // Proses form submit jika ada perubahan data
    if (isset($_POST['submit'])) {
        // Ambil data dari form
        $nama_poli = $_POST['nama_poli'];
        $deskripsi = $_POST['deskripsi'];
        $icon = $_POST['icon'];
        $gambar = $_FILES['gambar']['name'];
        $gambar_temp = $_FILES['gambar']['tmp_name'];
        $spesialis = $_POST['spesialis'];
        $dokter_ids_new = $_POST['dokter_id']; // Dokter yang dipilih

        // Jika gambar baru diupload, pindahkan gambar ke folder
        if ($gambar) {
            $gambar_update = $gambar;
            if (!move_uploaded_file($gambar_temp, 'images/' . $gambar)) {
                echo "Gagal upload gambar!";
                exit;
            }
        } else {
            $gambar_update = $poli['gambar']; // Tetap menggunakan gambar yang lama jika tidak diubah
        }

        // Query untuk update data poli
        $update_query = "UPDATE poli SET nama_poli = '$nama_poli', description = '$deskripsi', icon = '$icon', gambar = '$gambar_update', spesialis = '$spesialis' WHERE id = '$poli_id'";

        // Cek apakah query update berhasil
        if (mysqli_query($conn, $update_query)) {
            // Hapus dokter yang lama dari poli_dokter
            $delete_dokter_query = "DELETE FROM poli_dokter WHERE poli_id = '$poli_id'";
            mysqli_query($conn, $delete_dokter_query);

            // Masukkan dokter yang baru terpilih ke dalam poli_dokter
            foreach ($dokter_ids_new as $dokter_id) {
                $insert_dokter_query = "INSERT INTO poli_dokter (poli_id, dokter_id) VALUES ('$poli_id', '$dokter_id')";
                mysqli_query($conn, $insert_dokter_query);
            }

            // Cek apakah update berhasil
            if (mysqli_affected_rows($conn) > 0) {
                echo "Data poli berhasil diupdate!";
                header("Location: admin.php"); // Redirect ke halaman admin setelah update
                exit();  // Pastikan tidak ada eksekusi lebih lanjut
            } else {
                echo "Tidak ada perubahan pada data poli.";
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    echo "ID Poli tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Poli</title>

    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Gaya CSS tambahan -->
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
        select, textarea, input[type="file"], input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-submit {
            width: 100%;
            padding: 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
        .btn-back {
            width: 100%;
            padding: 10px;
            background-color: #6c757d;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            margin-top: 10px;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Poli</h2>
        <form action="edit_poli.php?id=<?php echo $poli_id; ?>" method="POST" enctype="multipart/form-data">
            <!-- Pilihan Poli -->
            <div class="form-group">
                <label for="nama_poli">Nama Poli:</label>
                <select name="nama_poli" class="form-control" required>
                    <option value="Mata" <?php if ($poli['nama_poli'] == 'Mata') echo 'selected'; ?>>Mata</option>
                    <option value="Anak" <?php if ($poli['nama_poli'] == 'Anak') echo 'selected'; ?>>Anak</option>
                    <option value="Kandungan" <?php if ($poli['nama_poli'] == 'Kandungan') echo 'selected'; ?>>Kandungan</option>
                    <option value="Penyakit Dalam" <?php if ($poli['nama_poli'] == 'Penyakit Dalam') echo 'selected'; ?>>Penyakit Dalam</option>
                    <option value="Gigi" <?php if ($poli['nama_poli'] == 'Gigi') echo 'selected'; ?>>Gigi</option>
                    <option value="Jantung" <?php if ($poli['nama_poli'] == 'Jantung') echo 'selected'; ?>>Jantung</option>
                    <option value="Kulit" <?php if ($poli['nama_poli'] == 'Kulit') echo 'selected'; ?>>Kulit</option>
                    <option value="THT" <?php if ($poli['nama_poli'] == 'THT') echo 'selected'; ?>>THT</option>
                </select>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea name="deskripsi" class="form-control" rows="4" required><?php echo $poli['description']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="icon">Icon (Font Awesome):</label>
                <input type="text" name="icon" class="form-control" required value="<?php echo $poli['icon']; ?>">
            </div>

            <div class="form-group">
                <label for="gambar">Gambar (Kosongkan jika tidak ingin mengganti gambar):</label>
                <input type="file" name="gambar" class="form-control">
                <small class="form-text text-muted">Gambar saat ini: <img src="images/<?php echo $poli['gambar']; ?>" alt="Gambar Poli" width="100"></small>
            </div>

            <!-- Dropdown untuk memilih spesialisasi poli -->
            <div class="form-group">
                <label for="spesialis">Spesialisasi:</label>
                <select name="spesialis" class="form-control" required>
                    <option value="Mata" <?php if ($poli['spesialis'] == 'Mata') echo 'selected'; ?>>Mata</option>
                    <option value="Anak" <?php if ($poli['spesialis'] == 'Anak') echo 'selected'; ?>>Anak</option>
                    <option value="Kandungan" <?php if ($poli['spesialis'] == 'Kandungan') echo 'selected'; ?>>Kandungan</option>
                    <option value="Penyakit Dalam" <?php if ($poli['spesialis'] == 'Penyakit Dalam') echo 'selected'; ?>>Penyakit Dalam</option>
                    <option value="Gigi" <?php if ($poli['spesialis'] == 'Gigi') echo 'selected'; ?>>Gigi</option>
                    <option value="Jantung" <?php if ($poli['spesialis'] == 'Jantung') echo 'selected'; ?>>Jantung</option>
                    <option value="Kulit" <?php if ($poli['spesialis'] == 'Kulit') echo 'selected'; ?>>Kulit</option>
                    <option value="THT" <?php if ($poli['spesialis'] == 'THT') echo 'selected'; ?>>THT</option>
                </select>
            </div>

            <!-- Dropdown untuk memilih dokter berdasarkan spesialisasi -->
            <div class="form-group">
                <label for="dokter_id">Dokter:</label>
                <select name="dokter_id[]" id="dokter_id" class="form-control" multiple required>
                    <?php
                    // Ambil dokter berdasarkan spesialisasi poli yang sedang diedit
                    $query_dokter = "SELECT id, nama, spesialis FROM dokterinfo WHERE spesialis = '{$poli['spesialis']}'";
                    $result_dokter = mysqli_query($conn, $query_dokter);
                    
                    // Loop untuk menampilkan dokter
                    while ($dokter = mysqli_fetch_assoc($result_dokter)) {
                        $selected = in_array($dokter['id'], $dokter_ids) ? 'selected' : '';
                        echo "<option value='{$dokter['id']}' {$selected}>{$dokter['nama']} - {$dokter['spesialis']}</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" name="submit" class="btn-submit">Simpan Perubahan</button>
        </form>

        <a href="admin.php">
            <button class="btn-back">Kembali ke Halaman Admin</button>
        </a>
    </div>
</body>
</html>
