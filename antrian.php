<?php
include('dbconn.php'); // Pastikan koneksi database sudah benar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $service = $_POST['service'];
    $doctor = $_POST['doctor'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $notes = $_POST['notes'];

    $query = "INSERT INTO appointments (name, email, phone, service, doctor, date, time, notes) 
              VALUES ('$name', '$email', '$phone', '$service', '$doctor', '$date', '$time', '$notes')";
    
    if (mysqli_query($conn, $query)) {
        echo "Antrian berhasil ditambahkan!";
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Antrian</title>
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

        input[type="text"], input[type="email"], input[type="phone"], input[type="date"], input[type="time"], textarea {
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

        .btn-back {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }

        a {
            display: inline-block;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Antrian</h1>
        <form method="POST" action="">
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Telepon</label>
            <input type="text" id="phone" name="phone" required>

            <label for="service">Layanan</label>
            <input type="text" id="service" name="service" required>

            <label for="doctor">Dokter</label>
            <input type="text" id="doctor" name="doctor" required>

            <label for="date">Tanggal</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Waktu</label>
            <input type="time" id="time" name="time" required>

            <label for="notes">Catatan</label>
            <textarea id="notes" name="notes"></textarea>

            <button type="submit">Tambah Antrian</button>
        </form>
        <a href="admin.php" class="btn-back">Kembali ke Beranda</a>
    </div>
</body>
</html>
