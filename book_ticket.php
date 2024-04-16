<?php
// book_ticket.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webprojectdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start(); // Start the session to access user information

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $flightId = $_GET['flightId'];

    // Get the passenger name from the session (you should set it when the user logs in)
    $passengerName = $_SESSION['email']; // Assuming the session variable is 'username'

    // Fetch flight information
    $flightSql = "SELECT Name, Itinerary ,PendingPassengers, StartTime, EndTime FROM flight WHERE ID = $flightId";
    $flightResult = $conn->query($flightSql);

    if ($flightResult && $flightResult->num_rows > 0) {
        $flightData = $flightResult->fetch_assoc();

        $companyName = $flightData['Name'];
        $itinerary = $flightData['Itinerary'];
        $pendingPassengers = $flightData['PendingPassengers'];
        $startTime = $flightData['StartTime'];
        $endTime = $flightData['EndTime'];

        // Update the flight to book the ticket
        $updateFlightSql = "UPDATE flight SET RegisteredPassengers = RegisteredPassengers + 1, TotalPassengers = TotalPassengers + 1, PendingPassengers = PendingPassengers - 1 WHERE ID = $flightId";
        
        // Insert a record into the booking table
        $insertBookingSql = "INSERT INTO booking (companyName, passengerName, itinerary, flightId, pendingPassengers, startTime, endTime) VALUES ('$companyName', '$passengerName', '$itinerary', $flightId, $pendingPassengers, '$startTime', '$endTime')";

        // Start a transaction to ensure atomicity
        $conn->begin_transaction();

        try {
            // Update the flight
            $conn->query($updateFlightSql);

            // Insert the booking record
            $conn->query($insertBookingSql);

            // Commit the transaction
            $conn->commit();

            $message = "Ticket booked successfully!";
        } catch (Exception $e) {
            // Rollback the transaction on exception
            $conn->rollback();

            $message = "Error booking ticket: " . $e->getMessage();
        }
    } else {
        $message = "Flight not found.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Ticket Result</title>
</head>
<body>
    <h2><?php echo $message; ?></h2>
    <p>Redirecting you back to search_flight_result.php...</p>

    <script>
        setTimeout(function () {
            window.location.href = "passenger_home.php";
        }, 3000); // Redirect after 3 seconds
    </script>
</body>
</html>
