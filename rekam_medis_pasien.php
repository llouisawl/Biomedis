<?php
include('dbconn.php');

// Query untuk mengambil semua rekam medis yang ada
$queryRekamMedis = "SELECT * FROM rekam_medis ORDER BY appointment_date DESC";
$resultRekamMedis = mysqli_query($conn, $queryRekamMedis);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="rekammedis.css" />
    <title>Rekam Medis - NumberOneHealth</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="Images/LogoNumberOneHealth.png" alt="Logo" />
            <a>Number<span>ONE</span>Health</a>
        </div>
        <nav class="navbar">
            <a href="index.php#Home">Beranda</a>
            <a href="index.php#Poli">Layanan Kami</a>
            <a href="index.php#Dokter">Temukan Dokter</a>
            <a href="index.php#Berita">Berita</a>
        </nav>
    </header>

    <section id="RekamMedis">
        <div class="rekammedis-heading">
            <h2>Rekam Medis</h2>
            <p>Detail informasi medis yang sudah dimasukkan oleh admin.</p>
        </div>
        <div class="rekammedis-container">
            <div class="rekammedis-record">
                <h3>Riwayat Medis</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Nama Pasien</th>
                            <th>Tanggal Lahir</th>
                            <th>Nomor Telepon</th>
                            <th>Tanggal Janji Temu</th>
                            <th>Diagnosa</th>
                            <th>Obat Diberikan</th>
                            <th>Catatan Dokter</th>
                            <th>Nama Dokter</th> <!-- Tambahkan kolom Nama Dokter -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($resultRekamMedis) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($resultRekamMedis)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['patient_name']) ?></td>
                                    <td><?= date("d F Y", strtotime($row['birthdate'])) ?></td>
                                    <td><?= htmlspecialchars($row['phone']) ?></td>
                                    <td><?= date("d F Y", strtotime($row['appointment_date'])) ?></td>
                                    <td><?= htmlspecialchars($row['diagnosa']) ?></td>
                                    <td><?= htmlspecialchars($row['obat']) ?></td>
                                    <td><?= htmlspecialchars($row['catatan_dokter']) ?></td>
                                    <td><?= htmlspecialchars($row['doctor_name']) ?></td> <!-- Menampilkan Nama Dokter -->
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="8">Tidak ada riwayat medis ditemukan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-top">
            <div class="footer-box">
                <div class="footer-grid">
                    <div class="footer-logo-info">
                        <h2>
                            <img src="Images/LogoNumberOneHealth.png" alt="Logo" class="footer-logo" />
                            <a>Number<span>ONE</span>Health</a>
                        </h2>
                    </div>
                    <div class="footer-contact">
                        <i class="fa-regular fa-envelope-open"></i>
                        <p>
                            Email: NumberOneHealth@gmail.com<br />
                            Inquiries: infoOneHealth@gmail.com
                        </p>
                    </div>
                    <div class="footer-contact">
                        <i class="fa-solid fa-phone"></i>
                        <p>
                            Office Telephone: 0029129102320<br />
                            Mobile: 000 2324 39493
                        </p>
                    </div>
                    <div class="footer-contact">
                        <i class="fa-solid fa-location-dot"></i>
                        <p>
                            Office Location:<br />
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
</body>
</html>
