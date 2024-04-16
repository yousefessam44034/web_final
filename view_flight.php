<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Replace this with your actual login logic to get the user's data from the database
    $loggedInUserEmail = $_SESSION['user_id'];

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
    $sqlUser = "SELECT * FROM users WHERE id='$loggedInUserEmail'";
    $resultUser = $conn->query($sqlUser);

    if ($resultUser->num_rows > 0) {
        $rowUser = $resultUser->fetch_assoc();
        $_SESSION['companyID'] = $rowUser['id']; // Assuming 'id' is the primary key in the 'users' table
        $companyID = $_SESSION['companyID'];

        // Check if the flight ID is provided in the URL
        if (isset($_GET['id'])) {
            $flightID = $_GET['id'];

            // Fetch flight details based on flight ID and company ID
            $sqlFlight = "SELECT * FROM flight WHERE ID='$flightID' AND companyID='$companyID'";
            $resultFlight = $conn->query($sqlFlight);

            if ($resultFlight === false) {
                die("Error fetching flight details: " . $conn->error);
            }

            // Check if there is a matching flight
            if ($resultFlight->num_rows > 0) {
                // Close the PHP tag to include HTML
                ?>
                <!DOCTYPE html>
                <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>View Flight</title>
                    <link rel="stylesheet" href="style.css">
                    <!-- Add your additional styles here -->
                    <style>
                        /* Add your additional styles specific to this page */
                        .flight-details {
                            margin-top: 20px;
                        }

                        .flight-details th, .flight-details td {
                            padding: 10px;
                            border: 1px solid #ddd;
                        }
                    </style>
                </head>

                <body>
                    <div class="header">
                        <h1>View Flight Details</h1>
                    </div>

                    <div class="navigation">
                        <!-- Add your navigation links here -->
                    </div>

                    <div class="content">
                        <h2>Flight Details</h2>

                        <!-- Display flight details -->
                        <table class="flight-details">
                            <?php
                            $rowFlight = $resultFlight->fetch_assoc();
                            echo "<tr><th>ID</th><td>{$rowFlight['ID']}</td></tr>";
                            echo "<tr><th>Name</th><td>{$rowFlight['Name']}</td></tr>";
                            echo "<tr><th>Itinerary</th><td>{$rowFlight['Itinerary']}</td></tr>";
                            echo "<tr><th>Fees</th><td>{$rowFlight['Fees']}</td></tr>";
                            echo "<tr><th>Registered Passengers</th><td>{$rowFlight['RegisteredPassengers']}</td></tr>";
                            echo "<tr><th>Pending Passengers</th><td>{$rowFlight['PendingPassengers']}</td></tr>";
                            echo "<tr><th>Total Passengers</th><td>{$rowFlight['TotalPassengers']}</td></tr>";
                            echo "<tr><th>Start Time</th><td>{$rowFlight['StartTime']}</td></tr>";
                            echo "<tr><th>End Time</th><td>{$rowFlight['EndTime']}</td></tr>";
                            echo "<tr><th>Completed</th><td>{$rowFlight['Completed']}</td></tr>";
                            echo "<tr><th>Time</th><td>{$rowFlight['Time']}</td></tr>";
                            ?>
                        </table>
                    </div>

                    <script src="scripts.js"></script>
                </body>

                </html>
                <?php
            } else {
                echo "Flight not found for the company.";
            }
        } else {
            echo "Flight ID not provided.";
        }
    } else {
        echo "User not found";
    }

    $conn->close();
} else {
    echo "User not logged in";
}
?>
