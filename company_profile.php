<?php
session_start();

// Check if the company is logged in
if (isset($_SESSION['user_id'])) {
    $companyID = $_SESSION['user_id'];

    // Establish database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "webprojectdb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Process the company profile update form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $tel = mysqli_real_escape_string($conn, $_POST['tel']);

        // Update company profile in the database
        $sqlUpdateCompany = "UPDATE users SET name='$name', email='$email', tel='$tel' WHERE id='$companyID' AND type='company'";

        if ($conn->query($sqlUpdateCompany) === TRUE) {
            echo "Company profile updated successfully";
        } else {
            echo "Error updating company profile: " . $conn->error;
        }
    }

    // Fetch company data based on the company ID
    $sqlCompany = "SELECT * FROM users WHERE id = '$companyID' AND type = 'company'";
    $resultCompany = $conn->query($sqlCompany);

    if ($resultCompany->num_rows > 0) {
        $rowCompany = $resultCompany->fetch_assoc();

        // Display the company profile form
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="styles.css">
            <title>Edit Company Profile</title>
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
                <h1>profile</h1>
            </div>    
        <div class="navigation">
                <ul>
                    <li><a href="homeCompany.php" >Home</a></li>
                    <li><a href="add_flight.php">Add Flight</a></li>s
                    <li><a href="flightlist.php">Flights</a></li>
                    <li><a href="#">Messages</a></li>
                    <li><a href="company_profile.php " class="active">profile</a></li>

                </ul>
            </div>
            <div class="container">
                <div id="company-profile" class="page">
                    <h2>Company Profile</h2>
                    <!-- Display the company data in the form -->
                    <form method="post" action="">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo $rowCompany['name']; ?>" required>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo $rowCompany['email']; ?>" required>

                        <label for="tel">Phone Number:</label>
                        <input type="tel" id="tel" name="tel" value="<?php echo $rowCompany['tel']; ?>" required>
 
                        <button type="submit">Save Changes</button>
                    </form>
                </div>
            </div>
        </body>

        </html>
        <?php
    } else {
        echo "Company not found.";
    }

    $conn->close();
} else {
    echo "Company not logged in.";
}
?>
