<?php
// Start the session
session_start();

// Include the database connection
include('dbconn.php');

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['id'];
$user_role = $_SESSION['role']; // 'admin' or 'user'

// Query to get user info if needed
$sql = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Get user appointments if needed
$appointments_sql = "SELECT * FROM appointments WHERE id = '$id' ORDER BY created_at DESC";
$appointments_result = $conn->query($appointments_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard | NumberOneHealth</title>
    <link rel="stylesheet" href="dashboard.css" />
</head>
<body>
    <header>
        <div class="logo">
            <img src="Images/LogoNumberOneHealth.png" alt="NumberOneHealth Logo" />
            <a>Number<span>ONE</span>Health</a>
        </div>
        <nav class="navbar">
            <a href="dashboard.php">Dashboard</a>
            <?php if ($user_role == 'admin'): ?>
                <a href="manage_users.php">Manage Users</a>
                <a href="admin_dashboard.php">Admin Dashboard</a>
            <?php endif; ?>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h1>Welcome, <?= htmlspecialchars($user['email']) ?>!</h1>

        <section class="appointments">
            <h2>Your Appointments</h2>
            <?php if ($appointments_result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Service</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($appointment = $appointments_result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $appointment['id'] ?></td>
                                <td><?= htmlspecialchars($appointment['service']) ?></td>
                                <td><?= htmlspecialchars($appointment['doctor']) ?></td>
                                <td><?= htmlspecialchars($appointment['date']) ?></td>
                                <td><?= htmlspecialchars($appointment['time']) ?></td>
                                <td><?= htmlspecialchars($appointment['notes']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No appointments found.</p>
            <?php endif; ?>
        </section>

        <!-- Admin specific content -->
        <?php if ($user_role == 'admin'): ?>
            <section class="admin-section">
                <h2>Admin Controls</h2>
                <p>Here you can manage users, appointments, and more.</p>
                <!-- Add Admin Specific Controls -->
            </section>
        <?php endif; ?>
    </main>

    <footer>
        <div class="footer-top">
            <div class="footer-box">
                <div class="footer-grid">
                    <div class="footer-logo-info">
                        <h2><img src="Images/LogoNumberOneHealth.png" alt="Logo" class="footer-logo"> 
                        <a>Number<span>ONE</span>Health</a></h2>
                    </div>
                    <div class="footer-contact">
                        <i class="fa-regular fa-envelope-open"></i>
                        <p>Email: NumberOneHealth@gmail.com<br>Inquiries: infoOneHealth@gmail.com</p>
                    </div>
                    <div class="footer-contact">
                        <i class="fa-solid fa-phone"></i>
                        <p>Office Telephone: 0029129102320<br>Mobile: 000 2324 39493</p>
                    </div>
                    <div class="footer-contact">
                        <i class="fa-solid fa-location-dot"></i>
                        <p>Office Location:<br>Semangat Perjuangan No 100</p>
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
