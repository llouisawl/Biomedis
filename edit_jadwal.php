<?php
include('dbconn.php');

$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dokter = $_POST['dokter'];
    $hari = $_POST['hari'];
    $jam = $_POST['jam'];

    $sql = "UPDATE jadwal SET dokter='$dokter', hari='$hari', jam='$jam' WHERE id='$id'";
    if ($conn->query($sql)) {
        header("Location: jadwal.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    $result = $conn->query("SELECT * FROM jadwal WHERE id='$id'");
    $data = $result->fetch_assoc();
}
?>

<form method="POST">
    <input type="text" name="dokter" value="<?= $data['dokter'] ?>" required>
    <input type="text" name="hari" value="<?= $data['hari'] ?>" required>
    <input type="text" name="jam" value="<?= $data['jam'] ?>" required>
    <button type="submit">Update</button>
</form>
