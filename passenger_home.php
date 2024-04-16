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

        // Fetch flights booked by the user from the booking table
        $bookingSql = "SELECT * FROM booking WHERE passengerName = '$loggedInUserEmail'";
        $bookingResult = $conn->query($bookingSql);

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
            <div class="navigation">
                <ul>
                    <li><a href="passenger_home.php" class="active">Home</a></li>
                    <li><a href="search_flight.php">search Flights</a></li>
                    <li><a href="message.php">Messages</a></li>
                    <li><a href="passenger_profile.php">Profile</a></li>
                </ul>
            </div>
                <div id="passenger-home" class="page ">
                    <h2>Welcome, <?php echo $name; ?>!</h2>
                    <p>Email: <?php echo $email; ?></p>
                    <p>Phone Number: <?php echo $tel; ?></p>
                    
                    <h3>Your Booked Flights</h3>

                    <table  border="1" text-align="center">
                        <tr>
                            <th>ID</th>
                            <th>Company Name</th>
                            <th>Passenger Name</th>
                            <th>Itinerary</th>
                            <th>Flight ID</th>
                            <th>Pending Passengers</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Time</th>
                        </tr>
                        <?php
                        while ($bookingRow = $bookingResult->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $bookingRow['id'] . "</td>";
                            echo "<td>" . $bookingRow['companyName'] . "</td>";
                            echo "<td>" . $bookingRow['passengerName'] . "</td>";
                            echo "<td>" . $bookingRow['itinerary'] . "</td>";
                            echo "<td>" . $bookingRow['flightId'] . "</td>";
                            echo "<td>" . $bookingRow['pendingPassengers'] . "</td>";
                            echo "<td>" . $bookingRow['startTime'] . "</td>";
                            echo "<td>" . $bookingRow['endTime'] . "</td>";
                            echo "<td>" . $bookingRow['time'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>

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
