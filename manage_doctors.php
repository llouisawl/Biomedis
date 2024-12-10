<?php
include('dbconn.php');
session_start();

// Redirect if not admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];

    $sql = "INSERT INTO doctors (name, specialization) VALUES ('$name', '$specialization')";
    if ($conn->query($sql)) {
        $message = "Doctor added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Fetch doctors
$result = $conn->query("SELECT * FROM doctors");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Doctors</title>
</head>
<body>
    <h1>Manage Doctors</h1>
    
    <?php if (isset($message)) echo "<p>$message</p>"; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Doctor Name" required>
        <input type="text" name="specialization" placeholder="Specialization" required>
        <button type="submit">Add Doctor</button>
    </form>

    <h2>Doctors List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Specialization</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['specialization'] ?></td>
                    <td>
                        <a href="edit_doctor.php?id=<?= $row['id'] ?>">Edit</a>
                        <a href="delete_doctor.php?id=<?= $row['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
