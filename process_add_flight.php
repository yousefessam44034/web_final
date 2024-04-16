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
    $sqlUser = "SELECT * FROM users WHERE id=?";
    $stmtUser = $conn->prepare($sqlUser);

    if ($stmtUser) {
        $stmtUser->bind_param("s", $loggedInUserEmail);
        $stmtUser->execute();
        $resultUser = $stmtUser->get_result();

        if ($resultUser->num_rows > 0) {
            $rowUser = $resultUser->fetch_assoc();
            $companyID = $rowUser['id']; // Assuming 'id' is the primary key in the 'users' table
            $userType = $rowUser['type']; // Assuming 'type' indicates the user's role or type

            // Check if the user has the necessary permissions (e.g., company role)
            if ($userType === 'company') {
                // Process form submission only for authorized companies
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Retrieve data from the form
                    $name = $_POST['name'];
                    $itinerary = $_POST['itinerary'];
                    $fees = $_POST['fees'];
                    $registeredPassengers = $_POST['registered_passengers'];
                    $pendingPassengers = $_POST['pending_passengers'];
                    $totalPassengers = $_POST['total_passengers'];
                    $startTime = $_POST['start_time'];
                    $endTime = $_POST['end_time'];
                    $completed = $_POST['completed'];
                    $time = $_POST['time'];

                    // Prepare the SQL statement with placeholders
                    $sqlInsertFlight = "INSERT INTO flight (companyID, Name, Itinerary, Fees, RegisteredPassengers, PendingPassengers, TotalPassengers, StartTime, EndTime, Completed, Time)
                                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    // Create a prepared statement
                    $stmtInsertFlight = $conn->prepare($sqlInsertFlight);

                    if ($stmtInsertFlight) {
                        // Bind parameters to the statement
                        $stmtInsertFlight->bind_param("ssssiiissssi", $companyID, $name, $itinerary, $fees, $registeredPassengers, $pendingPassengers, $totalPassengers, $startTime, $endTime, $completed, $time);

                        // Execute the statement
                        if ($stmtInsertFlight->execute()) {
                            echo "Flight added successfully";
                        } else {
                            echo "Error adding flight: " . $stmtInsertFlight->error;
                        }

                        // Close the statement
                        $stmtInsertFlight->close();
                    } else {
                        echo "Error preparing flight insertion statement";
                    }
                }
            } else {
                echo "User does not have permission to add flights";
            }
        } else {
            echo "User not found";
        }

        // Close the user data statement
        $stmtUser->close();
    } else {
        echo "Error preparing user data retrieval statement";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "User not logged in";
}
?>
