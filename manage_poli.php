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
    $description = $_POST['description'];

    $sql = "INSERT INTO poli (name, description) VALUES ('$name', '$description')";
    if ($conn->query($sql)) {
        $message = "Poli added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Fetch poli
$result = $conn->query("SELECT * FROM poli");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Poli</title>
</head>
<body>
    <h1>Manage Poli</h1>
    
    <?php if (isset($message)) echo "<p>$message</p>"; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Poli Name" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <button type="submit">Add Poli</button>
    </form>

    <h2>Poli List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td>
                        <a href="edit_poli.php?id=<?= $row['id'] ?>">Edit</a>
                        <a href="delete_poli.php?id=<?= $row['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
