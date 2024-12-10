<?php
include('dbconn.php'); // Pastikan koneksi database sudah benar

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM appointments WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $appointment = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $service = $_POST['service'];
    $doctor = $_POST['doctor'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $notes = $_POST['notes'];

    $query = "UPDATE appointments SET name = '$name', email = '$email', phone = '$phone', 
              service = '$service', doctor = '$doctor', date = '$date', time = '$time', notes = '$notes' 
              WHERE id = $id";
    
    if (mysqli_query($conn, $query)) {
        echo "Antrian berhasil diperbarui!";
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
    <title>Edit Antrian</title>
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
        <h1>Edit Antrian</h1>
        <form method="POST" action="">
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" value="<?= $appointment['name'] ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= $appointment['email'] ?>" required>

            <label for="phone">Telepon</label>
            <input type="text" id="phone" name="phone" value="<?= $appointment['phone'] ?>" required>

            <label for="service">Layanan</label>
            <input type="text" id="service" name="service" value="<?= $appointment['service'] ?>" required>

            <label for="doctor">Dokter</label>
            <input type="text" id="doctor" name="doctor" value="<?= $appointment['doctor'] ?>" required>

            <label for="date">Tanggal</label>
            <input type="date" id="date" name="date" value="<?= $appointment['date'] ?>" required>

            <label for="time">Waktu</label>
            <input type="time" id="time" name="time" value="<?= $appointment['time'] ?>" required>

            <label for="notes">Catatan</label>
            <textarea id="notes" name="notes"><?= $appointment['notes'] ?></textarea>

            <button type="submit">Perbarui Antrian</button>
        </form>
        <a href="admin.php" class="btn-back">Kembali ke Beranda</a>
    </div>
</body>
</html>
