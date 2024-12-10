<?php
// Koneksi ke database
include('dbconn.php');

if (isset($_POST['submit'])) {
    // Ambil data dari form
    $nama_poli = $_POST['nama_poli']; // Nama Poli dipilih dari dropdown
    $deskripsi = $_POST['deskripsi'];
    $icon = $_POST['icon'];
    $gambar = $_FILES['gambar']['name'];
    $gambar_temp = $_FILES['gambar']['tmp_name'];
    $dokter_ids = $_POST['dokter_id'];  // Menambahkan pilihan dokter
    $spesialis = $_POST['spesialis'];  // Pilih spesialisasi poli yang dipilih

    // Pindahkan gambar ke folder yang sesuai
    move_uploaded_file($gambar_temp, 'images/' . $gambar);

    // Query untuk menyimpan data poli ke database
    $query = "INSERT INTO poli (nama_poli, description, icon, gambar, spesialis) 
              VALUES ('$nama_poli', '$deskripsi', '$icon', '$gambar', '$spesialis')";
    if (mysqli_query($conn, $query)) {
        // Ambil id poli yang baru saja disimpan
        $poli_id = mysqli_insert_id($conn);

        // Masukkan data dokter ke dalam tabel poli_dokter
        foreach ($dokter_ids as $dokter_id) {
            $query_dokter = "INSERT INTO poli_dokter (poli_id, dokter_id) VALUES ('$poli_id', '$dokter_id')";
            if (!mysqli_query($conn, $query_dokter)) {
                echo "Error: " . $query_dokter . "<br>" . mysqli_error($conn);
            }
        }

        echo "Poli berhasil ditambahkan dengan dokter terkait!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Poli</title>

    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Gaya CSS tambahan untuk penataan -->
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
        .dokter-list ul {
            list-style-type: none;
            padding-left: 0;
        }
        .dokter-list li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Poli Baru</h2>
        <form action="tambah_poli.php" method="POST" enctype="multipart/form-data">
            <!-- Pilihan Poli -->
            <div class="form-group">
                <label for="nama_poli">Nama Poli:</label>
                <select name="nama_poli" class="form-control" required>
                    <option value="Mata">Mata</option>
                    <option value="Anak">Anak</option>
                    <option value="Kandungan">Kandungan</option>
                    <option value="Penyakit Dalam">Penyakit Dalam</option>
                    <option value="Gigi">Gigi</option>
                    <option value="Jantung">Jantung</option>
                    <option value="Kulit">Kulit</option>
                    <option value="THT">THT</option>
                </select>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="icon">Icon (Font Awesome):</label>
                <input type="text" name="icon" class="form-control" required placeholder="Contoh: fa-tooth">
            </div>

            <div class="form-group">
                <label for="gambar">Gambar:</label>
                <input type="file" name="gambar" class="form-control" required>
            </div>

            <!-- Dropdown untuk memilih spesialisasi poli -->
            <div class="form-group">
                <label for="spesialis">Spesialisasi:</label>
                <select name="spesialis" id="spesialis" class="form-control" required onchange="filterDokter()">
                    <option value="Mata">Mata</option>
                    <option value="Anak">Anak</option>
                    <option value="Kandungan">Kandungan</option>
                    <option value="Penyakit Dalam">Penyakit Dalam</option>
                    <option value="Gigi">Gigi</option>
                    <option value="Jantung">Jantung</option>
                    <option value="Kulit">Kulit</option>
                    <option value="THT">THT</option>
                </select>
            </div>

            <!-- Dropdown untuk memilih dokter berdasarkan spesialisasi -->
            <div class="form-group">
                <label for="dokter_id">Dokter:</label>
                <select name="dokter_id[]" id="dokter_id" class="form-control" multiple required>
                    <?php
                    // Query untuk mengambil dokter berdasarkan spesialisasi
                    $query_dokter = "SELECT id, nama, spesialis FROM dokterinfo";
                    $result_dokter = mysqli_query($conn, $query_dokter);
                    
                    // Loop untuk menampilkan dokter di dropdown
                    if (mysqli_num_rows($result_dokter) > 0) {
                        while ($dokter = mysqli_fetch_assoc($result_dokter)) {
                            echo "<option class='{$dokter['spesialis']}' value='{$dokter['id']}'>{$dokter['nama']} - {$dokter['spesialis']}</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <button type="submit" name="submit" class="btn-submit">Tambah Poli</button>
        </form>

        <!-- Tombol Kembali ke Halaman Admin -->
        <a href="admin.php">
            <button class="btn-back">Kembali ke Halaman Admin</button>
        </a>
    </div>

    <script>
        // Fungsi untuk menyaring dokter berdasarkan spesialisasi yang dipilih
        function filterDokter() {
            var spesialis = document.getElementById('spesialis').value;
            var dokterOptions = document.querySelectorAll('#dokter_id option');

            dokterOptions.forEach(function(option) {
                if (option.className !== spesialis && option.value !== "") {
                    option.style.display = "none"; // Sembunyikan dokter yang tidak sesuai spesialisasi
                } else {
                    option.style.display = "block"; // Tampilkan dokter yang sesuai spesialisasi
                }
            });
        }

        // Memanggil fungsi filterDokter saat pertama kali halaman dimuat
        filterDokter();
    </script>
</body>
</html>
