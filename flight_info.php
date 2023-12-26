<!-- flight_info.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Flight Info</title>
</head>

<body>
    <div class="container">
        <div id="flight-info" class="page">
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

            // Get the flight ID from the URL
            $flightId = $_GET['id']; // Assuming the parameter name is 'id' in the URL

            // Fetch flight details based on the flight ID
            $sql = "SELECT * FROM flight WHERE Id='$flightId'";
            $result = $conn->query($sql);

            if ($result !== false && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id = isset($row['Id']) ? $row['Id'] : '';
                $name = isset($row['Name']) ? $row['Name'] : '';
                $itinerary = isset($row['Itinerary']) ? $row['Itinerary'] : '';
                $registeredPassengers = isset($row['RegisteredPassengers']) ? $row['RegisteredPassengers'] : '';
                $pendingPassengers = isset($row['PendingPassengers']) ? $row['PendingPassengers'] : '';
                $totalPassengers = isset($row['TotalPassengers']) ? $row['TotalPassengers'] : '';
                $fees = isset($row['Fees']) ? $row['Fees'] : '';
                $startTime = isset($row['StartTime']) ? $row['StartTime'] : '';
                $endTime = isset($row['EndTime']) ? $row['EndTime'] : '';
                $completed = isset($row['Completed']) ? $row['Completed'] : '';
            
                // ... (rest of the code)
            } else {
                echo "Flight not found";
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>

</html>
