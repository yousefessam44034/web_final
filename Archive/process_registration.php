<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$dbname = "webprojectdb";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $tel = $_POST['tel'];
    $type = $_POST['type'];

    $sql = "INSERT INTO users (email, name, password, tel, type)
            VALUES ('$email', '$name', '$password', '$tel', '$type')";

    if ($conn->query($sql) === TRUE) {
        echo "User registered successfully";
    } else {
        echo "Error registering user: " . $conn->error;
    }
}

$conn->close();
?>
