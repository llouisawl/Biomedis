<?php
// Mulai sesi jika diperlukan
session_start();

// Masukkan koneksi ke database
include('dbconn.php');
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Poli Jantung</title>
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
        <img
          src="Images/LogoNumberOneHealth.png"
          alt="Logo Number One Health"
        />
        <a href="#">Number<span>ONE</span>Health</a>
      </div>
      <nav class="navbar">
        <a href="index.php">Beranda</a>
        <div class="dropdown">
          <a href="#">Layanan Kami</a>
          <div class="dropdown-menu">
            <a href="poli_gigi.php">Poli Gigi</a>
            <a href="poli_anak.php">Poli Anak</a>
            <a href="poli_kandungan.php">Poli Kandungan</a>
            <a href="poli_bedah.php">Poli Bedah</a>
            <a href="poli_jantung.php">Poli Jantung</a>
            <a href="poli_tht.php">Poli THT</a>
            <a href="poli_kulit_dan_kelamin.php">Poli Kulit dan Kelamin</a>
            <a href="poli_penyakit_dalam.php">Poli Penyakit Dalam</a>
          </div>
        </div>
      </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-content">
        <h1>Poli Jantung</h1>
        <p>
          Layanan kesehatan untuk diagnosis, perawatan, dan pencegahan penyakit
          jantung dengan dokter spesialis kardiologi yang berpengalaman.
        </p>
      </div>
    </section>

    <!-- Deskripsi Poli -->
    <section id="poli-info" class="poli-container">
      <div class="poli-box">
        <img src="images/jantung.jpeg" alt="Poli Jantung" />
        <div class="poli-content">
          <h2>Deskripsi Poli Jantung</h2>
          <p>
            Poli Jantung memberikan pelayanan untuk mendiagnosis dan mengelola
            berbagai gangguan kardiovaskular, seperti hipertensi, aritmia,
            penyakit jantung koroner, dan gagal jantung.
          </p>
          <h3>Jadwal Layanan</h3>
           <!-- Jadwal Dokter -->
           <table>
            <thead>
              <tr>
                <th>Nama Dokter</th>
                <th>Hari</th>
                <th>Jam</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Query untuk mendapatkan jadwal dokter yang melayani Poli Anak
              $query = "SELECT name, hari, jam FROM dokter WHERE Lokasi LIKE '%Poli Jantung%'";
              $result = mysqli_query($conn, $query);

              // Periksa apakah data ada
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['hari']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['jam']) . "</td>";
                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='3'>Tidak ada jadwal dokter untuk Poli .</td></tr>";
              }
              ?>
            </tbody>
          </table>

          <div class="Home-btn">
            <a href="appointment.php">
              <i class="fa-regular fa-calendar-days"></i>
              Buat Janji Temu</a
            >
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
