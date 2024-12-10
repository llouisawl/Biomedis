<?php
// Menghubungkan dengan file koneksi database
include 'dbconn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $pasien_id = $_POST['pasien_id'];
    $poli_id = $_POST['poli_id'];
    $dokter_id = $_POST['dokter_id'];
    $diagnosis = $_POST['diagnosis'];

    // Query untuk memasukkan data
    $query = "INSERT INTO rekam_medis (pasien_id, poli_id, dokter_id, diagnosis) 
              VALUES (?, ?, ?, ?)";

    // Gunakan prepared statement untuk keamanan
    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind parameter
        mysqli_stmt_bind_param($stmt, "iiis", $pasien_id, $poli_id, $dokter_id, $diagnosis);

        // Eksekusi statement
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Rekam Medis berhasil ditambahkan!'); window.location.href='data_rekam_medis.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_stmt_error($stmt) . "');</script>";
        }

        // Tutup statement
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error preparing statement: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Rekam Medis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
            font-size: 16px;
            color: #333;
        }

        input[type="text"], textarea, select {
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Rekam Medis</h1>
        <form action="tambah_rekam_medis.php" method="POST">
            <label for="pasien_id">Nama Pasien</label>
            <select name="pasien_id" id="pasien_id" required>
                <?php
                // Ambil data pasien dari tabel 'users'
                $query = "SELECT id, name FROM users WHERE role = 'user'";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                } else {
                    echo "<option disabled>Error loading patients</option>";
                }
                ?>
            </select>

            <label for="poli_id">Poli</label>
            <select name="poli_id" id="poli_id" required>
                <?php
                // Ambil data poli dari tabel 'poli'
                $query = "SELECT id, nama_poli FROM poli";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id']}'>{$row['nama_poli']}</option>";
                    }
                } else {
                    echo "<option disabled>Error loading polyclinics</option>";
                }
                ?>
            </select>

            <label for="dokter_id">Dokter</label>
            <select name="dokter_id" id="dokter_id" required>
                <?php
                // Ambil data dokter dari tabel 'dokter'
                $query = "SELECT id, name FROM dokter";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                } else {
                    echo "<option disabled>Error loading doctors</option>";
                }
                ?>
            </select>

            <label for="diagnosis">Diagnosis</label>
            <textarea name="diagnosis" id="diagnosis" rows="5" required></textarea>

            <button type="submit">Tambah Rekam Medis</button>
        </form>
    </div>
</body>
</html>
