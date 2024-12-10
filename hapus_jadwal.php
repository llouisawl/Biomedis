<?php
include('dbconn.php');

$id = $_GET['id'];
$sql = "DELETE FROM jadwal WHERE id='$id'";
if ($conn->query($sql)) {
    header("Location: jadwal.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>