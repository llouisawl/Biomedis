<?php
include 'dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_poli = $_POST['nama_poli'];
    $description = $_POST['description'];

    $query = "INSERT INTO poli (nama_poli, description) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $nama_poli, $description);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: admin.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Poli</title>
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
        <h1>Tambah Poli</h1>
        <form method="POST">
            <label for="nama_poli">Nama Poli</label>
            <input type="text" id="nama_poli" name="nama_poli" required>

            <label for="description">Deskripsi</label>
            <textarea id="description" name="description" rows="5"></textarea>

            <button type="submit">Simpan</button>
        </form>
        <a href="admin.php" class="btn-back">Kembali</a>
    </div>
</body>
</html>
