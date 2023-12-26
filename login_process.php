<?php
// Start the session
session_start();

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webprojectdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validate user credentials
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User authenticated, set session variable and redirect
        $row = $result->fetch_assoc();

        // Set the session variable
        $_SESSION['email'] = $email;

        // Redirect to passenger.php or Company.php based on user type
        if ($row['type'] == 'passenger') {
            header("Location: passenger_home.php");
        } else {
            // Redirect to another page for other user types
            header("Location: Company.php");
        }
    } else {
        // Invalid credentials, redirect back to login page
        header("Location: login.html");
    }
}

$conn->close();
?>