<?php
// Koneksi ke database
include('dbconn.php');

// Ambil ID dari URL
$id = $_GET['id'];

// Query untuk mendapatkan data poli berdasarkan ID
$query = "SELECT * FROM poli WHERE id = '$id'";
$result = mysqli_query($conn, $query);

// Cek apakah data ditemukan
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "Poli tidak ditemukan.";
    exit;
}

// Query untuk mengambil dokter yang memiliki spesialisasi sesuai dengan poli ini
$query_dokter = "SELECT id, nama, spesialis, gambar, profil, jadwal, kontak_email, kontak_telepon 
                 FROM dokterinfo WHERE spesialis = '{$row['nama_poli']}'";
$result_dokter = mysqli_query($conn, $query_dokter);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Poli - <?php echo $row['nama_poli']; ?></title>
    <link rel="stylesheet" href="poli.css" />
    <!-- Font dan Icon -->
    <link
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
    />
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <img src="Images/LogoNumberOneHealth.png" alt="Logo Number One Health" />
            <a href="#">Number<span>ONE</span>Health</a>
        </div>
        <nav class="navbar">
            <a href="index.php">Beranda</a>
            <div class="dropdown">
                <a href="#">Layanan Kami</a>
                <div class="dropdown-menu">
                    <?php
                    // Query untuk menampilkan semua poli di dropdown
                    $query_poli = "SELECT * FROM poli";
                    $result_poli = mysqli_query($conn, $query_poli);
                    
                    // Loop untuk menampilkan link ke setiap poli
                    while ($poli = mysqli_fetch_assoc($result_poli)) {
                        echo "<a href='poli_detail.php?id={$poli['id']}'>{$poli['nama_poli']}</a>";
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1><?php echo $row['nama_poli']; ?></h1>
        </div>
    </section>

    <!-- Deskripsi Poli -->
    <section id="poli-info" class="poli-container">
        <div class="poli-box">
            <img src="images/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_poli']; ?>" />
            <div class="poli-content">
                <h2>Deskripsi <?php echo $row['nama_poli']; ?></h2>
                <p>
                    <?php echo $row['description']; ?>
                </p>
                <h3>Dokter Tersedia</h3>
                <!-- Daftar Dokter berdasarkan Spesialisasi Poli -->
                <ul>
                    <?php
                    if (mysqli_num_rows($result_dokter) > 0) {
                        while ($dokter = mysqli_fetch_assoc($result_dokter)) {
                            echo "<li><i class='fa-solid fa-user-doctor'></i> Dr. {$dokter['nama']}</li>";

                            // Menampilkan Jadwal Praktik Dokter
                            $jadwal = explode("\n", $dokter['jadwal']); // Memisahkan setiap jadwal per baris
                            echo "<ul>";
                            foreach ($jadwal as $row) {
                                $detail = explode("|", $row); // Pisahkan Hari | Jam | Lokasi
                                if (count($detail) == 4) {
                                    echo "<li><strong>{$detail[0]}</strong>: {$detail[1]} - {$detail[2]} di {$detail[3]}</li>";
                                }
                            }
                            echo "</ul>"; // Menutup daftar jadwal
                        }
                    } else {
                        echo "<li>Tidak ada dokter untuk poli ini.</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </section>
</body>
</html>
