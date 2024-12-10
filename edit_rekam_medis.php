<?php
include('dbconn.php'); // Pastikan file koneksi sesuai dengan nama yang benar

// Ambil ID rekam medis yang akan diedit
$rekam_medis_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($rekam_medis_id) {
    // Ambil data rekam medis berdasarkan ID
    $query = "SELECT * FROM rekam_medis WHERE id = '$rekam_medis_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $rekam_medis = mysqli_fetch_assoc($result);

        // Form values
        $janji_temu_id = $rekam_medis['janji_temu_id'];
        $patient_name = $rekam_medis['patient_name'];
        $birthdate = $rekam_medis['birthdate'];
        $phone = $rekam_medis['phone'];
        $appointment_date = $rekam_medis['appointment_date'];
        $doctor_name = $rekam_medis['doctor_name'];
        $diagnosa = $rekam_medis['diagnosa'];
        $obat = $rekam_medis['obat'];
        $catatan_dokter = $rekam_medis['catatan_dokter'];

        // Jika form disubmit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ambil data yang diupdate
            $diagnosa = mysqli_real_escape_string($conn, $_POST['diagnosa']);
            $obat = mysqli_real_escape_string($conn, $_POST['obat']);
            $catatan_dokter = mysqli_real_escape_string($conn, $_POST['catatan_dokter']);

            // Update data rekam medis
            $updateQuery = "UPDATE rekam_medis SET diagnosa = '$diagnosa', obat = '$obat', catatan_dokter = '$catatan_dokter' WHERE id = '$rekam_medis_id'";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                echo "<p>Rekam medis berhasil diperbarui!</p>";
            } else {
                echo "<p>Gagal memperbarui rekam medis: " . mysqli_error($conn) . "</p>";
            }
        }
    } else {
        echo "<p>Rekam medis tidak ditemukan.</p>";
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
    <title>Edit Rekam Medis</title>
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

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input, select, textarea, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #007BFF;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        textarea {
            height: 150px;
            resize: none;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group input[readonly] {
            background-color: #f9f9f9;
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
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Rekam Medis</h2>

    <form method="POST" action="edit_rekam_medis.php?id=<?= $rekam_medis_id ?>">
        <div class="form-group">
            <label for="patient_name">Nama Pasien:</label>
            <input type="text" id="patient_name" name="patient_name" value="<?= htmlspecialchars($patient_name) ?>" readonly />
        </div>

        <div class="form-group">
            <label for="birthdate">Tanggal Lahir:</label>
            <input type="date" id="birthdate" name="birthdate" value="<?= $birthdate ?>" readonly />
        </div>

        <div class="form-group">
            <label for="phone">Nomor Telepon:</label>
            <input type="tel" id="phone" name="phone" value="<?= $phone ?>" readonly />
        </div>

        <div class="form-group">
            <label for="appointment_date">Tanggal Janji Temu:</label>
            <input type="date" id="appointment_date" name="appointment_date" value="<?= $appointment_date ?>" readonly />
        </div>

        <div class="form-group">
            <label for="doctor_name">Nama Dokter:</label>
            <input type="text" id="doctor_name" name="doctor_name" value="<?= $doctor_name ?>" readonly />
        </div>

        <div class="form-group">
            <label for="diagnosa">Diagnosa:</label>
            <textarea id="diagnosa" name="diagnosa" required><?= htmlspecialchars($diagnosa) ?></textarea>
        </div>

        <div class="form-group">
            <label for="obat">Obat:</label>
            <textarea id="obat" name="obat" required><?= htmlspecialchars($obat) ?></textarea>
        </div>

        <div class="form-group">
            <label for="catatan_dokter">Catatan Dokter:</label>
            <textarea id="catatan_dokter" name="catatan_dokter"><?= htmlspecialchars($catatan_dokter) ?></textarea>
        </div>

        <button type="submit">Perbarui Rekam Medis</button>
    </form>

    <a href="admin.php" class="back-button">Kembali ke Halaman Admin</a>
</div>
</body>
</html>
