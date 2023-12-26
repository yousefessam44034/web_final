<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover:not(.active) {
  background-color: #111;
}

.active {
  background-color: #04AA6D;
}
</style>
</head>
<body>
    <div class="header">
        <h1>flight list</h1>
    </div>    
<div class="navigation">
                <ul>
                    <li><a href="cccccc.php" >Home</a></li>
                    <li><a href="add_flight.php">Add Flight</a></li>
                    <li><a href="flightlist.php"class="active">Flights</a></li>
                    <li><a href="#">Messages</a></li>
                    <li><a href="company_profile.php">profile</a></li>

                </ul>
            </div>
</body>
</html>
<br><br><br>
<?php
session_start();
// Check if the company is logged in
if (isset($_SESSION['companyID'])) {
    $companyID = $_SESSION['companyID'];

    // Establish database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "flight_booking_system";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch flights for the logged-in company
    $sqlFlights = "SELECT * FROM flight WHERE companyID = '$companyID'";
    $resultFlights = $conn->query($sqlFlights);

    if ($resultFlights->num_rows > 0) {
        // Display flight data in a table
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Itinerary</th>
                    <th>Fees</th>
                    <th>Registered Passengers</th>
                    <th>Pending Passengers</th>
                    <th>Total Passengers</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Completed</th>
                    <th>Time</th>
                </tr>";

        while ($rowFlight = $resultFlights->fetch_assoc()) {
            echo "<tr>
                    <td>{$rowFlight['ID']}</td>
                    <td>{$rowFlight['Name']}</td>
                    <td>{$rowFlight['Itinerary']}</td>
                    <td>{$rowFlight['Fees']}</td>
                    <td>{$rowFlight['RegisteredPassengers']}</td>
                    <td>{$rowFlight['PendingPassengers']}</td>
                    <td>{$rowFlight['TotalPassengers']}</td>
                    <td>{$rowFlight['StartTime']}</td>
                    <td>{$rowFlight['EndTime']}</td>
                    <td>{$rowFlight['Completed']}</td>
                    <td>{$rowFlight['Time']}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "No flights found for the company.";
    }

    $conn->close();
} else {
    echo "Company not logged in.";
}
?>
