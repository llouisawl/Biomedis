<?php
// Start the session
session_start();

// Include the database connection
include('dbconn.php');

// Define a variable to store error messages
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate form inputs
    if (empty($name) || empty($email) || empty($password)) {
        $error_message = "All fields are required!";
    } else {
        // Check if email already exists in the database
        $sql_check = "SELECT * FROM users WHERE email = '$email'";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            $error_message = "Email is already registered!";
        } else {
            // Hash the password using MD5
            $hashed_password = md5($password); // MD5 hash for password

            // Insert new user into the database
            $sql_insert = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', 'user')";

            if ($conn->query($sql_insert) === TRUE) {
                // Redirect to login page after successful registration
                header("Location: login.php");
                exit();
            } else {
                $error_message = "Error: " . $sql_insert . "<br>" . $conn->error;
            }
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration</title>
    <link rel="stylesheet" href="registration.css" />
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php">
                <img src="Images/LogoNumberOneHealth.png" alt="NumberOneHealth Logo" />
                <a>Number<span>ONE</span>Health</a>
            </a>
        </div>
    </header>

    <div class="container">
        <main>
            <div class="registration-box">
                <h1>REGISTRATION</h1>
                <?php
                if (!empty($error_message)) {
                    echo "<p style='color: red;'>$error_message</p>";
                }
                ?>
                <form action="registration.php" method="post">
                    <div class="textbox">
                        <input type="text" placeholder="Name" name="name" required />
                    </div>
                    <div class="textbox">
                        <input type="email" placeholder="Email" name="email" required />
                    </div>
                    <div class="textbox">
                        <input type="password" placeholder="Password" name="password" required />
                    </div>
                    <button type="submit" class="btn">Register</button>
                    <div class="register">
                        <p>Already have an account? <a href="login.php">Log In</a></p>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <footer>
        <div class="footer-top">
            <div class="footer-box">
                <div class="footer-grid">
                    <div class="footer-logo-info">
                        <h2><img src="Images/LogoNumberOneHealth.png" alt="Logo" class="footer-logo">
                            <a>Number<span>ONE</span>Health</a></h2>
                    </div>

                    <!-- Email Section -->
                    <div class="footer-contact">
                        <i class="fa-regular fa-envelope-open"></i>
                        <p>Email: NumberOneHealth@gmail.com<br>Inquiries: infoOneHealth@gmail.com</p>
                    </div>

                    <!-- Phone Section -->
                    <div class="footer-contact">
                        <i class="fa-solid fa-phone"></i>
                        <p>Office Telephone: 0029129102320<br>Mobile: 000 2324 39493</p>
                    </div>

                    <!-- Location Section -->
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
