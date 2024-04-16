<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Replace this with your actual login logic to get the user's data from the database
    $loggedInUserId = $_SESSION['user_id'];

    // Establish database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "webprojectdb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch user data based on the logged-in user's ID
    $sql = "SELECT * FROM users WHERE id='$loggedInUserId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $tel = $row['tel'];

        // Close the PHP tag to include HTML
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="styles.css">
            <title>Company Profile</title>
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
                <h1>Home</h1>
            </div>

            <div class="navigation">
                <ul>
                    <li><a href="homeCompany.php" class="active">Home</a></li>
                    <li><a href="add_flight.php">Add Flight</a></li>
                    <li><a href="flightlist.php">Flights</a></li>
                    <li><a href="message.php">Messages</a></li>
                    <li><a href="company_profile.php">Profile</a></li>
                </ul>
            </div>

            <div class="content">
                <h2><?php echo $name; ?>'s Home</h2>

                <!-- Display user details in a form -->
                <form method="post" action="profile.php">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

                    <label for="tel">Phone Number:</label>
                    <input type="tel" id="tel" name="tel" value="<?php echo $tel; ?>" required>

                    <!-- Add other user details (Bio, Address, Logo Image, etc.) -->

                    <button type="submit">Save Changes</button>
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
