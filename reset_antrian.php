<?php
// session_start() jika ada kebutuhan session, seperti untuk login
session_start();

// Include the database connection
include('dbconn.php');

$query = "DELETE FROM queue";
if ($conn->query($query) === TRUE) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal mereset antrian']);
}
?>
