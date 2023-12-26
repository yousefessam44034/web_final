<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['email'])) {
    // Replace this with your actual login logic to get the user's data from the database
    $loggedInUserEmail = $_SESSION['email'];

    // Establish database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "webprojectdb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch user data based on the logged-in user's email
    $sql = "SELECT * FROM users WHERE email='$loggedInUserEmail'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $tel = $row['tel'];

        // Close the PHP tag to include HTML
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="styles.css">
            <title>Passenger Home</title>
        </head>

        <body>
            <div class="container">
                <div id="passenger-home" class="page">
                    <h2>Welcome, <?php echo $name; ?>!</h2>
                    <p>Email: <?php echo $email; ?></p>
                    <p>Phone Number: <?php echo $tel; ?></p>
                    <p><a href="passenger_profile.php">View Profile</a></p>
                    <p><a href="search_flight.php">Search for a Flight</a></p>
                    <!-- Add more links/buttons as needed -->
                </div>
            </div>
        </body>

        </html>
        <?php
    } else {
        echo "User not found";
    }

    $conn->close();
} else {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}
?>
