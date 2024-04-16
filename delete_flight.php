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

        if (isset($_GET['id'])) {
            $flightID = $_GET['id'];

            $sqlDeleteFlight = "DELETE FROM flight WHERE ID='$flightID' AND companyID='$companyID'";
            $resultDelete = $conn->query($sqlDeleteFlight);

            if ($resultDelete) {
                echo "Flight deleted successfully!";
            } else {
                echo "Error deleting flight: " . $conn->error;
            }
        } else {
            echo "Invalid request!";
        }
    } else {
        echo "User not found";
    }

    $conn->close();
} else {
    echo "User not logged in";
}
?>
