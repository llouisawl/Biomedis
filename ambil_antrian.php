<?php
// session_start() jika ada kebutuhan session, seperti untuk login
session_start();

// Include the database connection
include('dbconn.php');

// Fungsi untuk mengambil nomor antrian terakhir
function getLastQueueNumber($poli) {
    global $conn;
    $query = "SELECT MAX(nomor_antrian) AS last_number FROM queue WHERE poli = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $poli);
    $stmt->execute();
    $stmt->bind_result($last_number);
    $stmt->fetch();
    $stmt->close();
    
    return $last_number ? $last_number + 1 : 1;
}

// Fungsi untuk menambahkan antrian baru ke database
function addQueue($poli, $dokter, $nomor_antrian) {
    global $conn;
    $query = "INSERT INTO queue (poli, dokter, nomor_antrian) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $poli, $dokter, $nomor_antrian);
    $stmt->execute();
    $stmt->close();
}

// Jika form ambil nomor antrian dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $poli = $_POST['poli'];
    $dokter = $_POST['dokter'];
    
    if ($poli && $dokter) {
        $nomor_antrian = getLastQueueNumber($poli); // Mendapatkan nomor antrian berikutnya
        addQueue($poli, $dokter, $nomor_antrian); // Menambahkan antrian baru
        
        echo json_encode(['status' => 'success', 'nomor_antrian' => $nomor_antrian]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Poli dan Dokter harus dipilih']);
    }
    exit();
}

// Fungsi untuk mendapatkan daftar antrian
function getQueueList() {
    global $conn;
    $query = "SELECT poli, dokter, nomor_antrian, waktu_antrian FROM queue ORDER BY waktu_antrian DESC";
    $result = $conn->query($query);
    $queues = [];
    
    while ($row = $result->fetch_assoc()) {
        $queues[] = $row;
    }
    
    return $queues;
}

// Ambil daftar antrian jika diperlukan
$queueList = getQueueList();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Ambil Antrian</title>
    <link rel="stylesheet" href="ambil antrian.css" />
  </head>
  <body>
    <header>
      <div class="logo">
        <a href="index.php">
          <img
            src="Images/LogoNumberOneHealth.png"
            alt="NumberOneHealth Logo"
          />
          <a>Number<span>ONE</span>Health</a>
        </a>
      </div>
    </header>
    <div class="container">
      <h1>Ambil Nomor Antrian</h1>

      <div class="poli-selection">
        <label for="poli">Pilih Poli:</label>
        <select id="poli">
          <option value="">Pilih Poli</option>
          <option value="poli_anak">Poli Anak</option>
          <option value="poli_bedah">Poli Bedah</option>
          <option value="poli_kulit_dan_kelamin">Poli Kulit dan Kelamin</option>
          <option value="poli_tht">Poli THT</option>
          <option value="poli_penyakit_dalam">Poli Penyakit Dalam</option>
          <option value="poli_ginekologi">Poli Kandungan</option>
        </select>
      </div>

      <div class="dokter-selection">
        <label for="dokter">Pilih Dokter:</label>
        <select id="dokter">
          <option value="">Pilih Dokter</option>
        </select>
      </div>

      <div class="counter">
        <span id="currentNumber">0</span>
      </div>
      <button id="takeNumberBtn">Ambil Nomor</button>

      <h2>Daftar Antrian</h2>
      <ul id="queueList"></ul>

      <button id="resetBtn">Reset Antrian</button>
    </div>

    <script src="ambil antrian.js"></script>
  </body>
</html>
