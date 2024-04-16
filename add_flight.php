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

        // Close the PHP tag to include HTML
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Add Flight</title>
            <link rel="stylesheet" href="style.css">
            <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f4f4f4;
        }

        .header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .navigation {
            background-color: #333;
            overflow: hidden;
        }

        .navigation a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navigation a:hover {
            background-color: #111;
        }

        .navigation .active {
            background-color: #04AA6D;
        }

        .content {
            padding: 20px;
        }

        form {
            max-width: 600px;
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #04AA6D;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #045C3E;
        }
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


    </style>
        </head>

        <body>
            <div class="header">
                <h1>Add Flight</h1>
            </div>

            <div class="navigation">
                <ul>
                    <li><a href="homeCompany.php" >Home</a></li>
                    <li><a href="add_flight.php" class="active">Add Flight</a></li>
                    <li><a href="flightlist.php">Flights</a></li>
                    <li><a href="#">Messages</a></li>
                    <li><a href="company_profile.php">profile</a></li>
                </ul>
            </div>

            <div class="content">
                <h2>Add a New Flight</h2>

                <form method="post" action="process_add_flight.php">
                    <!-- Display flight details form -->
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                    
                    <label for="itinerary">Itinerary:</label>
                    <input type="text" id="itinerary" name="itinerary" required>
                    <br><br>
                    <label for="fees">Fees:</label>
                    <input type="text" id="fees" name="fees" required>
                
                    <label for="registered_passengers">Registered Passengers:</label>
                    <input type="text" id="registered_passengers" name="registered_passengers" required>
                    <br><br>
                    <label for="pending_passengers">Pending Passengers:</label>
                    <input type="text" id="pending_passengers" name="pending_passengers" required>
                    
                    <label for="total_passengers">Total Passengers:</label>
                    <input type="text" id="total_passengers" name="total_passengers" required>
                    <br><br>
                    <label for="start_time">Start Time:</label>
                    <input type="text" id="start_time" name="start_time" required>

                    <label for="end_time">End Time:</label>
                    <input type="text" id="end_time" name="end_time" required>
                    <br><br>
                    <label for="completed">Completed (1 for Yes, 0 for No):</label>
                    <input type="text" id="completed" name="completed" required>

                    <label for="time">Time:</label>
                    <input type="text" id="time" name="time" required>
                    <br><br>
                    <button type="submit">Add Flight</button>
                </form>
            </div>

            <script src="scripts.js"></script>
        </body>

        </html>
        <?php
    } else {
        echo "User not found";
    }

    $conn->close();
} else {
    echo "User not logged in";
}
?>