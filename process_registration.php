<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webprojectdb";

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

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO users (email, name, password, tel, type) VALUES (?, ?, ?, ?, ?)";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters to the statement
        $stmt->bind_param("sssss", $email, $name, $password, $tel, $type);

        // Execute the statement
        if ($stmt->execute()) {
            echo "User registered successfully";
            header("Location: login.html");
            exit; // Prevent further execution after redirection
        } else {
            echo "Error registering user";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement";
    }
}

// Close the connection
$conn->close();
?>
