<?php
session_start();

// Check if the user is logged in as a passenger
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'passenger') {
    // Replace this with your actual login logic to get the user's data from the database
    $passengerId = $_SESSION['user_id'];

    // Establish database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "webprojectdb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch all companies
    $sqlCompanies = "SELECT id, company_name FROM users WHERE type = 'company'";
    $resultCompanies = $conn->query($sqlCompanies);

    // Check if there are companies to display
    if ($resultCompanies->num_rows > 0) {
        // Close the PHP tag to include HTML
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Send Message</title>
            <link rel="stylesheet" href="styles.css">
            <!-- Add any additional styles or scripts if needed -->
        </head>

        <body>
            <div class="header">
                <h1>Send Message</h1>
            </div>

            <div class="content">
                <h2>Select a Company to Message:</h2>

                <form action="process_send_message.php" method="post">
                    <label for="company">Select Company:</label>
                    <select name="company" id="company" required>
                        <?php
                        // Display company options
                        while ($rowCompany = $resultCompanies->fetch_assoc()) {
                            echo "<option value='{$rowCompany['id']}'>{$rowCompany['company_name']}</option>";
                        }
                        ?>
                    </select>

                    <label for="message_content">Message:</label>
                    <textarea name="message_content" id="message_content" rows="4" required></textarea>

                    <button type="submit">Send Message</button>
                </form>
            </div>

            <script src="scripts.js"></script>
        </body>

        </html>
        <?php
    } else {
        echo "No companies available for messaging.";
    }

    $conn->close();
} else {
    echo "Access denied. Please log in as a passenger.";
}
?>