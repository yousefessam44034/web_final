<!-- search_flight_result.php -->

<?php
// Assume you have a MySQL database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webprojectdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process search form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itinerary = $_POST['itinerary'];

    // Perform a query to get the list of available flights based on the search criteria
    $sql = "SELECT * FROM flight WHERE itinerary LIKE '%$itinerary%'";
    $result = $conn->query($sql);

    if ($result) {
        
        if ($result->num_rows > 0) {
            // Display the list of available flights
            echo "<h2>Available Flights</h2>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Itinerary</th><th>Registered Passengers</th><th>Pending Passengers</th><th>Total Passengers</th><th>Fees</th><th>Start Time</th><th>End Time</th><th>Completed</th><th>Action</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . (isset($row['Id']) ? $row['Id'] : '') . "</td>";
                echo "<td>" . (isset($row['Name']) ? $row['Name'] : '') . "</td>";
                echo "<td>" . (isset($row['Itinerary']) ? $row['Itinerary'] : '') . "</td>";
                echo "<td>" . (isset($row['Registered_passengers']) ? $row['Registered_passengers'] : '') . "</td>";
                echo "<td>" . (isset($row['Pending_passengers']) ? $row['Pending_passengers'] : '') . "</td>";
                echo "<td>" . (isset($row['Total_passengers']) ? $row['Total_passengers'] : '') . "</td>";
                echo "<td>" . (isset($row['Fees']) ? $row['Fees'] : '') . "</td>";
                echo "<td>" . (isset($row['Start_time']) ? $row['Start_time'] : '') . "</td>";
                echo "<td>" . (isset($row['End_time']) ? $row['End_time'] : '') . "</td>";
                echo "<td>" . (isset($row['completed']) ? $row['Completed'] : '') . "</td>";
                echo "<td><a href='flight_info.php?id=" . (isset($row['Id']) ? $row['id'] : '') . "'>View Details</a></td>";
                echo "</tr>";
            }
            

            echo "</table>";
        } else {
            echo "No flights found";
        }
    } else {
        die("Query failed: " . $conn->error);
    }
}

$conn->close();
?>
