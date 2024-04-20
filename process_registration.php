<?php

// Include database connection configuration
include_once 'db_config.php';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password securely
    $tel = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_STRING);
    $type = $_POST['type']; // No sanitization as it's a predefined value

    // Prepare SQL statement to insert user data
    $stmt = $conn->prepare("INSERT INTO users (email, name, password, tel, type) VALUES (?, ?, ?, ?, ?)");

    // Bind parameters and execute statement
    $stmt->bind_param("sssss", $email, $name, $password, $tel, $type);

    if ($stmt->execute()) {
        echo "User registered successfully";
        // Redirect to login page after successful registration
        header("Location: login.html");
        exit(); // Ensure script execution stops after redirection
    } else {
        echo "Error registering user: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$conn->close();
?>