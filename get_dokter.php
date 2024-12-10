<?php
// session_start() jika ada kebutuhan session, seperti untuk login
session_start();

// Include the database connection
include('dbconn.php');

$poli = isset($_GET['poli']) ? $_GET['poli'] : '';

if ($poli) {
    $query = "SELECT dokter FROM queue WHERE poli = ? GROUP BY dokter";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $poli);
    $stmt->execute();
    $result = $stmt->get_result();

    $dokterList = [];
    while ($row = $result->fetch_assoc()) {
        $dokterList[] = $row['dokter'];
    }
    
    echo json_encode($dokterList);
} else {
    echo json_encode([]);
}
?>
