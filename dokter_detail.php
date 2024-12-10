<?php
// Koneksi ke database dengan pengecekan error
include('dbconn.php'); 

// Pastikan parameter 'id' ada dan valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID dokter tidak valid.";
    exit;
}

$id = $_GET['id'];

// Gunakan prepared statement untuk menghindari SQL injection
$query = "SELECT * FROM dokterinfo WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Cek apakah dokter ditemukan
$dokter = mysqli_fetch_assoc($result);
if (!$dokter) {
    echo "Dokter tidak ditemukan.";
    exit;
}

$gambarPath = 'images/' . $dokter['gambar']; // Path gambar dokter

// Menyimpan data dokter untuk keperluan di halaman janji temu
$doctor_id = $dokter['id'];  // ID dokter
$doctor_name = $dokter['nama'];  // Nama dokter
$poli_name = $dokter['spesialis'];  // Nama spesialis/poli
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Rubik:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <link rel="stylesheet" href="dokter.css" />
    <title>Dr. <?php echo $dokter['nama']; ?></title>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <img src="Images/LogoNumberOneHealth.png" alt="NumberOneHealth Logo" />
            <a>Number<span>ONE</span>Health</a>
        </div>

        <nav class="navbar">
            <a href="index.php#Home">Beranda</a>
            <a href="index.php#Poli">Layanan Kami</a>
            <a href="index.php#Dokter">Temukan Dokter</a>
            <a href="index.php#Berita">Berita</a>
        </nav>
    </header>

    <!-- Section: Dokter Detail -->
    <section id="DokterDetail">
        <div class="dokter-heading">
            <h1><?php echo $dokter['nama']; ?></h1>
            <p><?php echo $dokter['spesialis']; ?></p>
        </div>
        <div class="dokter-detail-container">
            <div class="dokter-img">
                <img src="<?php echo $gambarPath; ?>" alt="<?php echo $dokter['nama']; ?>" />
            </div>
            <div class="dokter-detail-text">
                <h2>Profil Dokter</h2>
                <p><?php echo nl2br($dokter['profil']); ?></p>

                <h2>Jadwal Praktik</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Lokasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Menampilkan jadwal
                        if (!empty($dokter['jadwal'])) {
                            $jadwal = explode("\n", $dokter['jadwal']); // Pisahkan berdasarkan baris
                            foreach ($jadwal as $row) {
                                $detail = explode("|", $row); // Pisahkan setiap kolom berdasarkan "|"
                                if (count($detail) == 4) { // Pastikan ada 4 elemen: Hari, Jam Mulai, Jam Selesai, Lokasi
                                    echo "<tr>
                                            <td>{$detail[0]}</td>
                                            <td>{$detail[1]}</td>
                                            <td>{$detail[2]}</td>
                                            <td>{$detail[3]}</td>
                                          </tr>";
                                }
                            }
                        } else {
                            echo "<tr><td colspan='4'>Jadwal belum tersedia.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <h2>Kontak</h2>
                <p>
                    Email: <?php echo $dokter['kontak_email']; ?><br />
                    Telepon: <?php echo $dokter['kontak_telepon']; ?>
                </p>

                <!-- Tombol Buat Janji Temu -->
                <div class="Home-btn">
                    <a href="appointment.php?doctor_id=<?= $doctor_id ?>&doctor_name=<?= urlencode($doctor_name) ?>&poli=<?= urlencode($poli_name) ?>">Buat Janji Temu</a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
