<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $loggedInUserEmail = $_SESSION['user_id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "webprojectdb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sqlUser = "SELECT * FROM users WHERE id='$loggedInUserEmail'";
    $resultUser = $conn->query($sqlUser);

    if ($resultUser->num_rows > 0) {
        $rowUser = $resultUser->fetch_assoc();
        $_SESSION['companyID'] = $rowUser['id'];
        $companyID = $_SESSION['companyID'];

        $sqlFlights = "SELECT * FROM flight WHERE companyID='$companyID'";
        $resultFlights = $conn->query($sqlFlights);

        if ($resultFlights === false) {
            die("Error fetching flights: " . $conn->error);
        }

        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Flight List</title>
            <link rel="stylesheet" href="styles.css">
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

                table {
                    border-collapse: collapse;
                    width: 100%;
                }

                th, td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: left;
                }

                th {
                    background-color: #f2f2f2;
                }

                .view-button, .delete-button {
                    background-color: #4CAF50;
                    color: white;
                    border: none;
                    padding: 5px 10px;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    font-size: 12px;
                    cursor: pointer;
                    margin-right: 5px;
                }

                .delete-button {
                    background-color: #f44336;
                }
            </style>
        </head>

        <body>
            <div class="header">
                <h1>Flight List</h1>
            </div>

            <div class="navigation">
                <ul>
                    <li><a href="homeCompany.php">Home</a></li>
                    <li><a href="add_flight.php">Add Flight</a></li>
                    <li><a href="flightlist.php" class="active">Flights</a></li>
                    <li><a href="#">Messages</a></li>
                    <li><a href="company_profile.php">Profile</a></li>
                </ul>
            </div>

            <div class="content">
                <h2>Flight List</h2>

                <!-- Display flight list -->
                <table>
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
                        <th>Actions</th>
                    </tr>

                    <?php
                    while ($rowFlight = $resultFlights->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $rowFlight['ID'] . "</td>";
                        echo "<td>" . $rowFlight['Name'] . "</td>";
                        echo "<td>" . $rowFlight['Itinerary'] . "</td>";
                        echo "<td>" . $rowFlight['Fees'] . "</td>";
                        echo "<td>" . $rowFlight['RegisteredPassengers'] . "</td>";
                        echo "<td>" . $rowFlight['PendingPassengers'] . "</td>";
                        echo "<td>" . $rowFlight['TotalPassengers'] . "</td>";
                        echo "<td>" . $rowFlight['StartTime'] . "</td>";
                        echo "<td>" . $rowFlight['EndTime'] . "</td>";
                        echo "<td>" . $rowFlight['Completed'] . "</td>";
                        echo "<td>" . $rowFlight['Time'] . "</td>";
                        echo "<td>";
                        echo "<a class='view-button' href='view_flight.php?id=" . $rowFlight['ID'] . "'>View</a>";
                        echo "<a class='delete-button' href='delete_flight.php?id=" . $rowFlight['ID'] . "'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>

                </table>
            </div>

            <script src="scripts.js"></script>
        </body>

        </html>
        <?php
    } else {
        echo "No flights found for the company.";
    }
} else {
    echo "User not logged in";
}
?>
