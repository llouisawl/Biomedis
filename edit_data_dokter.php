<?php
include('dbconn.php'); // Pastikan koneksi database sudah benar

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM data_dokter WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $dokter = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_dokter = $_POST['nama_dokter'];
    $spesialis = $_POST['spesialis'];

    $query = "UPDATE data_dokter SET nama_dokter = '$nama_dokter', spesialis = '$spesialis' WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo "Data dokter berhasil diperbarui!";
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
    <title>Edit Dokter</title>
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

        input[type="text"] {
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
        <h1>Edit Dokter</h1>
        <form method="POST" action="">
            <label for="nama_dokter">Nama Dokter</label>
            <input type="text" id="nama_dokter" name="nama_dokter" value="<?php echo $dokter['nama']; ?>" required>

            <label for="spesialis">Spesialis</label>
            <input type="text" id="spesialis" name="spesialis" value="<?php echo $dokter['spesialis']; ?>" required>

            <button type="submit">Perbarui Dokter</button>
        </form>
        <a href="admin.php" class="btn-back">Kembali ke Beranda</a>
    </div>
</body>
</html>
