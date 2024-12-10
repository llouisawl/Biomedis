<?php
include('dbconn.php');

// Ambil data dokter dari URL
$doctor_id = isset($_GET['doctor_id']) ? $_GET['doctor_id'] : null;

// Validasi doctor_id
if (!$doctor_id) {
    die("ID Dokter tidak ditemukan di URL.");
}

// Ambil informasi dokter berdasarkan doctor_id
$query = "SELECT * FROM dokterinfo WHERE id = '$doctor_id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

$doctor = mysqli_fetch_assoc($result);

if (!$doctor) {
    die("Dokter dengan ID $doctor_id tidak ditemukan.");
}

// Ambil jadwal dokter
$jadwal_array = !empty($doctor['jadwal']) ? explode("\n", $doctor['jadwal']) : [];

// Ambil waktu yang sudah terisi untuk dokter ini
$bookedTimes = [];
$queryBooked = "SELECT day, time FROM janji_temu WHERE doctor_id = '$doctor_id'";
$resultBooked = mysqli_query($conn, $queryBooked);

while ($row = mysqli_fetch_assoc($resultBooked)) {
    $bookedTimes[$row['day']][] = $row['time'];
}

// Variabel untuk memunculkan pop-up sukses
$showSuccessPopup = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $poli = mysqli_real_escape_string($conn, $doctor['spesialis']);
    $day = mysqli_real_escape_string($conn, $_POST['day']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);

    // Insert data ke tabel janji_temu
    $queryInsert = "INSERT INTO janji_temu (doctor_id, doctor_name, name, birthdate, phone, poli, day, time, notes) 
                    VALUES ('$doctor_id', '" . mysqli_real_escape_string($conn, $doctor['nama']) . "', '$name', '$birthdate', '$phone', '$poli', '$day', '$time', '$notes')";

    $resultInsert = mysqli_query($conn, $queryInsert);

    if ($resultInsert) {
        $showSuccessPopup = true; // Set variabel untuk menampilkan pop-up
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="janji temu.css" />
  <title>NumberOneHealth</title>
</head>
<body>
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

<main>
    <section class="appointment-form">
        <h2>Buat Janji Temu dengan <?= htmlspecialchars($doctor['nama']) ?></h2>
        <form id="appointmentForm" method="POST">
            <!-- Informasi dokter -->
            <div class="form-group">
                <label for="doctor_name">Dokter:</label>
                <input type="text" id="doctor_name" value="<?= htmlspecialchars($doctor['nama']) ?>" readonly />
            </div>
            <div class="form-group">
                <label for="poli">Poli:</label>
                <input type="text" id="poli" value="<?= htmlspecialchars($doctor['spesialis']) ?>" readonly />
            </div>

            <!-- Informasi pasien -->
            <div class="form-group">
                <label for="name">Nama Pasien:</label>
                <input type="text" id="name" name="name" placeholder="Masukkan nama Anda" required />
            </div>
            <div class="form-group">
                <label for="birthdate">Tanggal Lahir:</label>
                <input type="date" id="birthdate" name="birthdate" required />
            </div>
            <div class="form-group">
                <label for="phone">Nomor Telepon:</label>
                <input type="tel" id="phone" name="phone" placeholder="Masukkan nomor telepon Anda" required />
            </div>

            <!-- Pilih Hari -->
            <div class="form-group">
                <label for="day">Pilih Hari:</label>
                <select id="day" name="day" required>
                    <option value="">Pilih Hari</option>
                    <?php foreach ($jadwal_array as $entry): 
                        list($hari, $jam_mulai, $jam_selesai, $lokasi) = explode('|', $entry);
                    ?>
                        <option value="<?= $hari ?>"><?= $hari ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Pilih Waktu -->
            <div class="form-group">
                <label for="time">Waktu:</label>
                <select id="time" name="time" required>
                    <option value="">Pilih waktu</option>
                </select>
            </div>

            <div class="form-group">
                <label for="notes">Catatan Tambahan:</label>
                <textarea id="notes" name="notes" placeholder="Tulis catatan Anda di sini (opsional)"></textarea>
            </div>

            <button type="submit" class="btn">Ajukan Janji Temu</button>
        </form>
    </section>
</main>

<script>
// Menampilkan pop-up jika janji temu berhasil dibuat
<?php if ($showSuccessPopup): ?>
    alert("Janji Temu Anda Berhasil Dibuat!");
<?php endif; ?>

// JavaScript untuk menampilkan waktu yang tersedia
document.getElementById('day').addEventListener('change', function() {
    const selectedDay = this.value;
    const jadwalArray = <?= json_encode($jadwal_array) ?>;
    const bookedTimes = <?= json_encode($bookedTimes) ?>;
    const timeSelect = document.getElementById('time');
    timeSelect.innerHTML = "<option value=''>Pilih Waktu</option>";

    jadwalArray.forEach(entry => {
        const [hari, jamMulai, jamSelesai] = entry.split('|');
        if (hari === selectedDay) {
            let startTime = jamMulai;
            const endTime = jamSelesai;

            while (startTime < endTime) {
                const [startHour, startMinute] = startTime.split(':').map(Number);
                const nextTime = new Date(0, 0, 0, startHour + 1, startMinute);
                const formattedTime = `${startTime}-${nextTime.toTimeString().substr(0, 5)}`;

                const option = document.createElement('option');
                option.value = formattedTime;
                option.textContent = formattedTime;

                // Menonaktifkan waktu yang sudah terisi
                if (bookedTimes[selectedDay] && bookedTimes[selectedDay].includes(formattedTime)) {
                    option.disabled = true; // Nonaktifkan opsi yang sudah terisi
                }

                timeSelect.appendChild(option);
                startTime = nextTime.toTimeString().substr(0, 5);
            }
        }
    });
});
</script>
</body>
</html>
