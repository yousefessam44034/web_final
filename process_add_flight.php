
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
    $dbname = "flight_booking_system";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch user data based on the logged-in user's email
    $sqlUser = "SELECT * FROM users WHERE email='$loggedInUserEmail'";
    $resultUser = $conn->query($sqlUser);

    if ($resultUser->num_rows > 0) {
        $rowUser = $resultUser->fetch_assoc();
        $_SESSION['companyID'] = $rowUser['id']; // Assuming 'id' is the primary key in the 'users' table
        $companyID = $_SESSION['companyID'];

        // Process form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve data from the form
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $itinerary = mysqli_real_escape_string($conn, $_POST['itinerary']);
            $fees = $_POST['fees'];
            $registeredPassengers = $_POST['registered_passengers'];
            $pendingPassengers = $_POST['pending_passengers'];
            $totalPassengers = $_POST['total_passengers'];
            $startTime = $_POST['start_time'];
            $endTime = $_POST['end_time'];
            $completed = $_POST['completed'];
            $time = $_POST['time'];

            // Insert data into the flight table
            $sqlInsertFlight = "INSERT INTO flight (companyID, Name, Itinerary, Fees, RegisteredPassengers, PendingPassengers, TotalPassengers, StartTime, EndTime, Completed, Time)
                               VALUES ('$companyID', '$name', '$itinerary', '$fees', '$registeredPassengers', '$pendingPassengers', '$totalPassengers', '$startTime', '$endTime', '$completed', '$time')";

            if ($conn->query($sqlInsertFlight) === TRUE) {
                echo "Flight added successfully";
            } else {
                echo "Error: " . $sqlInsertFlight . "<br>" . $conn->error;
            }
        }
    } else {
        echo "User not found";
    }

    $conn->close();
} else {
    echo "User not logged in";
}
?>*/
