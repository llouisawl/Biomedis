<?php
include('dbconn.php');

// Ambil ID pasien dari query string
$janji_temu_id = isset($_GET['janji_temu_id']) ? $_GET['janji_temu_id'] : null;

if ($janji_temu_id) {
    // Query untuk mengambil detail pasien berdasarkan janji_temu_id
    $query = "SELECT jt.id, jt.name, jt.birthdate, jt.phone, jt.created_at, jt.doctor_name 
              FROM janji_temu jt WHERE jt.id = '$janji_temu_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $patient = mysqli_fetch_assoc($result);
        echo json_encode($patient);
    } else {
        echo json_encode(['error' => 'Pasien tidak ditemukan.']);
    }
} else {
    echo json_encode(['error' => 'ID pasien tidak ditemukan.']);
}
?>
