<?php
session_start();

// Include the database connection
include('dbconn.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - NumberOneHealth</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="Images/LogoNumberOneHealth.png" alt="NumberOneHealth Logo" />
            <a>Admin NumberOneHealth</a>
        </div>
        <a href="logout.php" class="btnout">Logout</a>
    </header>

    <main>
 <!-- Section: Data Berita -->
<section id="berita">
    <h2>Data Berita</h2>
    <button onclick="window.location.href='tambah_berita.php'">Tambah Berita</button>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Konten</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('dbconn.php'); // Pastikan koneksi database disertakan

                $query = "SELECT * FROM berita";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['judul']}</td>
                            <td>" . substr($row['konten'], 0, 50) . "...</td>
                            <td>
                                <img src='images/{$row['gambar']}' alt='Gambar Berita' style='width:100px; height:auto;'>
                            </td>
                            <td>
                                <a href='edit_berita.php?id={$row['id']}'><button>Edit</button></a>
                                <a href='hapus_berita.php?id={$row['id']}'><button>Hapus</button></a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</section>



       <!-- admin_dokter.php -->
<section id="dokter">
    <h2>Dokter</h2>
    <button onclick="window.location.href='tambah_dokter.php'">Tambah Dokter</button>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Dokter</th>
                    <th>Spesialis</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query untuk mengambil data dokter
                $query = "SELECT id, nama, spesialis, gambar FROM dokterinfo";
                $result = mysqli_query($conn, $query);

                // Periksa apakah data ada
                if (mysqli_num_rows($result) > 0) {
                    // Loop untuk menampilkan data dokter
                    while ($row = mysqli_fetch_assoc($result)) {
                        $gambarPath = 'images/' . $row['gambar']; // Path gambar dokter
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['nama']}</td>
                                <td>{$row['spesialis']}</td>
                                <td><img src='$gambarPath' alt='{$row['nama']}' width='100' height='100'></td>
                                <td>
                                    <a href='edit_dokter.php?id={$row['id']}'><button>Edit</button></a>
                                    <a href='hapus_dokter.php?id={$row['id']}'><button>Hapus</button></a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data dokter.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</section>

<section id="detailDokter">
    <h2>Kelola Detail Dokter</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Dokter</th>
                    <th>Profil</th>
                    <th>Jadwal Praktik</th>
                    <th>Kontak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query untuk mengambil data dokter dari database
                $query = "SELECT id, nama, spesialis, gambar, profil, jadwal, kontak_email, kontak_telepon FROM dokterinfo";
$result = mysqli_query($conn, $query);

// Periksa apakah ada data dokter
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Menampilkan data dokter dalam tabel
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nama']}</td>
                <td>" . substr($row['profil'], 0, 50) . "...</td> <!-- Profil Dokter -->
                <td>" . substr($row['jadwal'], 0, 50) . "...</td> <!-- Jadwal Praktik -->
                <td>Email: {$row['kontak_email']}<br>Telepon: {$row['kontak_telepon']}</td> <!-- Kontak -->
                <td>
                    <a href='edit_detail_dokter.php?id={$row['id']}'><button>Edit</button></a>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='6'>Tidak ada detail dokter yang tersedia.</td></tr>";
}


                ?>
            </tbody>
        </table>
    </div>
</section>



<!-- Section: Data Poli -->
<section id="poli">
    <h2>Data Poli</h2>
    <button onclick="window.location.href='tambah_poli.php'">Tambah Poli</button>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Poli</th>
                    <th>Deskripsi</th>
                    <th>Icon</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Koneksi ke database
                include('dbconn.php');

                // Query untuk mengambil data poli
                $query = "SELECT * FROM poli";
                $result = mysqli_query($conn, $query);

                // Cek apakah ada data
                if (mysqli_num_rows($result) > 0) {
                    // Loop untuk menampilkan data poli
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['nama_poli']}</td>
                                <td>{$row['description']}</td>
                                <td><i class='{$row['icon']}'></i></td>
                                <td><img src='images/{$row['gambar']}' alt='{$row['nama_poli']}' width='50'></td>
                                <td>
                                    <a href='poli_detail.php?id={$row['id']}'><button>Lihat Detail</button></a>
                                    <a href='edit_poli.php?id={$row['id']}'><button>Edit</button></a>
                                    <a href='hapus_poli.php?id={$row['id']}'><button>Hapus</button></a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data poli.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</section>

    <?php
include('dbconn.php'); // Pastikan koneksi ke database sudah benar

// Ambil ID pasien (jika diperlukan, bisa disesuaikan dengan kebutuhan)
$janji_temu_id = isset($_GET['janji_temu_id']) ? $_GET['janji_temu_id'] : null;

// Ambil data rekam medis berdasarkan janji_temu_id
$queryRiwayat = "SELECT * FROM rekam_medis"; // Mengambil semua rekam medis

// Jika janji_temu_id ada, filter berdasarkan itu
if ($janji_temu_id) {
    $queryRiwayat .= " WHERE janji_temu_id = '$janji_temu_id'";
}

$riwayat_result = mysqli_query($conn, $queryRiwayat);

// Periksa apakah query berhasil
if (!$riwayat_result) {
    echo "Query gagal: " . mysqli_error($conn);
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekam Medis</title>
</head>
<body>
<section id="RekamMedis">
    <div class="rekammedis-container">
        <div class="rekammedis-heading">
            <button onclick="window.location.href='tambah_rekam_medis.php'">Tambah Rekam Medis</button>
        </div>

        <div class="rekammedis-record">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Tanggal Lahir</th>
                        <th>Nomor Telepon</th>
                        <th>Tanggal</th>
                        <th>Diagnosa</th>
                        <th>Obat Diberikan</th>
                        <th>Catatan Dokter</th>
                        <th>Dokter</th> <!-- Kolom Dokter -->
                        <th>Aksi</th> <!-- Kolom Aksi -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Periksa apakah ada data rekam medis
                    if ($riwayat_result && mysqli_num_rows($riwayat_result) > 0) {
                        while ($row = mysqli_fetch_assoc($riwayat_result)) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['patient_name']) . "</td>
                                    <td>" . date("d F Y", strtotime($row['birthdate'])) . "</td>
                                    <td>" . htmlspecialchars($row['phone']) . "</td>
                                    <td>" . date("d F Y", strtotime($row['appointment_date'])) . "</td>
                                    <td>" . htmlspecialchars($row['diagnosa']) . "</td>
                                    <td>" . htmlspecialchars($row['obat']) . "</td>
                                    <td>" . htmlspecialchars($row['catatan_dokter']) . "</td>
                                    <td>" . htmlspecialchars($row['doctor_name']) . "</td> <!-- Menampilkan nama dokter -->
                                    <td>
                                        <a href='edit_rekam_medis.php?id=" . $row['id'] . "'><button>Edit</button></a>
                                        <a href='hapus_rekam_medis.php?id=" . $row['id'] . "'><button>Hapus</button></a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>Tidak ada riwayat medis ditemukan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

</body>
</html>




        <footer>
  <div class="footer-top">
    <div class="footer-box">
      <div class="footer-grid">
        <div class="footer-logo-info">
          <h2>
            <img src="Images/LogoNumberOneHealth.png" alt="Logo" class="footer-logo"> 
            <a>Number<span>ONE</span>Health</a>
        </div>

        <!-- Email Section -->
        <div class="footer-contact">
          <i class="fa-regular fa-envelope-open"></i>
          <p>
             Email: NumberOneHealth@gmail.com<br>
             Inquiries: infoOneHealth@gmail.com
          </p>
        </div>

        <!-- Phone Section -->
        <div class="footer-contact">
          <i class="fa-solid fa-phone"></i>
          <p>
            Office Telephone: 0029129102320<br>
             Mobile: 000 2324 39493
          </p>
        </div>
        <div class="footer-contact">
          <i class="fa-solid fa-location-dot"></i>
          <p>
             Office Location:<br>
            Semangat Perjuangan No 100
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="social-icons">
      <a href="#"><i class="fa-brands fa-facebook"></i></a>
      <a href="#"><i class="fa-brands fa-twitter"></i></a>
      <a href="#"><i class="fa-brands fa-instagram"></i></a>
    </div>
    <p>© NumberOneHealth 2024 | All Rights Reserved by KelompokBiomedis</p>
  </div>
</footer>
    
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="script.js"></script>
  </body>
</html>