<?php
include('dbconn.php'); // Pastikan file koneksi sesuai dengan nama yang benar

// Ambil semua pasien untuk dropdown
$queryPatients = "SELECT id, name FROM janji_temu";
$resultPatients = mysqli_query($conn, $queryPatients);

// Inisialisasi variabel untuk form
$janji_temu_id = isset($_POST['janji_temu_id']) ? $_POST['janji_temu_id'] : null;
$patient_name = isset($_POST['patient_name']) ? $_POST['patient_name'] : ''; // Nama pasien dari dropdown
$birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$appointment_date = isset($_POST['appointment_date']) ? $_POST['appointment_date'] : '';
$doctor_name = isset($_POST['doctor_name']) ? $_POST['doctor_name'] : '';
$diagnosa = isset($_POST['diagnosa']) ? $_POST['diagnosa'] : '';
$obat = isset($_POST['obat']) ? $_POST['obat'] : '';
$catatan_dokter = isset($_POST['catatan_dokter']) ? $_POST['catatan_dokter'] : '';

// Validasi inputan saat form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Membersihkan input untuk mencegah SQL injection
    $patient_name = mysqli_real_escape_string($conn, $patient_name);
    $birthdate = mysqli_real_escape_string($conn, $birthdate);
    $phone = mysqli_real_escape_string($conn, $phone);
    $appointment_date = mysqli_real_escape_string($conn, $appointment_date);
    $doctor_name = mysqli_real_escape_string($conn, $doctor_name);
    $diagnosa = mysqli_real_escape_string($conn, $diagnosa);
    $obat = mysqli_real_escape_string($conn, $obat);
    $catatan_dokter = mysqli_real_escape_string($conn, $catatan_dokter);

    // Pastikan janji_temu_id tidak kosong dan semua input valid
    if ($patient_name && $birthdate && $phone && $appointment_date && $doctor_name && $diagnosa && $obat) {
        // Ambil nama pasien berdasarkan ID yang dipilih
        $queryPatientName = "SELECT name FROM janji_temu WHERE id = '$patient_name' LIMIT 1";
        $resultPatientName = mysqli_query($conn, $queryPatientName);

        if ($resultPatientName && mysqli_num_rows($resultPatientName) > 0) {
            $row = mysqli_fetch_assoc($resultPatientName);
            $patient_name = $row['name']; // Ambil nama pasien berdasarkan id

            // Ambil janji_temu_id berdasarkan ID pasien yang dipilih
            $queryJanjiTemu = "SELECT id FROM janji_temu WHERE name = '$patient_name' LIMIT 1";
            $resultJanjiTemu = mysqli_query($conn, $queryJanjiTemu);

            if ($resultJanjiTemu && mysqli_num_rows($resultJanjiTemu) > 0) {
                $row = mysqli_fetch_assoc($resultJanjiTemu);
                $janji_temu_id = $row['id']; // Ambil ID janji temu yang sesuai

                // Masukkan data rekam medis ke tabel rekam_medis
                $queryInsert = "INSERT INTO rekam_medis 
                                (janji_temu_id, patient_name, birthdate, phone, appointment_date, doctor_name, diagnosa, obat, catatan_dokter) 
                                VALUES 
                                ('$janji_temu_id', '$patient_name', '$birthdate', '$phone', '$appointment_date', '$doctor_name', '$diagnosa', '$obat', '$catatan_dokter')";

                $resultInsert = mysqli_query($conn, $queryInsert);

                if ($resultInsert) {
                    echo "<p>Rekam Medis berhasil disimpan!</p>";
                } else {
                    // Tampilkan error jika query gagal
                    echo "<p>Gagal menyimpan rekam medis: " . mysqli_error($conn) . "</p>";
                }
            } else {
                echo "<p>Pasien tidak ditemukan dalam tabel janji_temu.</p>";
            }
        } else {
            echo "<p>Nama pasien tidak ditemukan.</p>";
        }
    } else {
        echo "<p>Pastikan semua data terisi dengan benar.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Rekam Medis</title>
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
    <script>
        // Fungsi untuk mengambil detail pasien berdasarkan id
        function updatePatientDetails() {
            var patientId = document.getElementById('patient_name').value;
            if (patientId) {
                // Fetch data dari server berdasarkan id pasien yang dipilih
                fetch('get_patient_details.php?janji_temu_id=' + patientId)
                    .then(response => response.json())
                    .then(data => {
                        // Mengisi data pasien yang diterima
                        document.getElementById('birthdate').value = data.birthdate;
                        document.getElementById('phone').value = data.phone;
                        document.getElementById('appointment_date').value = data.created_at.split(' ')[0]; // Ambil tanggal dari created_at
                        document.getElementById('doctor_name').value = data.doctor_name;
                    })
                    .catch(error => console.error('Error fetching patient details:', error));
            }
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Tambah Rekam Medis</h2>

    <form method="POST" action="tambah_rekam_medis.php">
        <!-- Data Janji Temu -->
        <div class="form-group">
            <label for="patient_name">Nama Pasien:</label>
            <select id="patient_name" name="patient_name" required onchange="updatePatientDetails()">
                <option value="">Pilih Nama Pasien</option>
                <?php while ($patient = mysqli_fetch_assoc($resultPatients)): ?>
                    <option value="<?= htmlspecialchars($patient['id']) ?>"><?= htmlspecialchars($patient['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Hidden field untuk janji_temu_id -->
        <input type="hidden" name="janji_temu_id" id="janji_temu_id" />

        <!-- Patient details section -->
        <div class="form-group">
            <label for="birthdate">Tanggal Lahir:</label>
            <input type="date" id="birthdate" name="birthdate" readonly />
        </div>

        <div class="form-group">
            <label for="phone">Nomor Telepon:</label>
            <input type="tel" id="phone" name="phone" readonly />
        </div>

        <div class="form-group">
            <label for="appointment_date">Tanggal Janji Temu:</label>
            <input type="date" id="appointment_date" name="appointment_date" readonly />
        </div>

        <div class="form-group">
            <label for="doctor_name">Nama Dokter:</label>
            <input type="text" id="doctor_name" name="doctor_name" readonly />
        </div>

        <!-- Data Rekam Medis -->
        <div class="form-group">
            <label for="diagnosa">Diagnosa:</label>
            <textarea id="diagnosa" name="diagnosa" required></textarea>
        </div>

        <div class="form-group">
            <label for="obat">Obat:</label>
            <textarea id="obat" name="obat" required></textarea>
        </div>

        <div class="form-group">
            <label for="catatan_dokter">Catatan Dokter:</label>
            <textarea id="catatan_dokter" name="catatan_dokter"></textarea>
        </div>

        <button type="submit">Simpan Rekam Medis</button>
    </form>

    <!-- Back Button -->
    <a href="admin.php" class="back-button">Kembali ke Halaman Admin</a>
</div>
</body>
</html>
