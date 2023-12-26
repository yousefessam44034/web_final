<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Replace these with your actual database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "webprojectdb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get data from the AJAX request
    $field = $_POST['field'];
    $value = $_POST['value'];

    // Update the user's data in the database
    // Note: This is a basic example and should be adapted based on your actual database schema
    $loggedInUserEmail = $_SESSION['email'];
    $updateSql = "UPDATE users SET $field = '$value' WHERE email = '$loggedInUserEmail'";

    if ($conn->query($updateSql) === TRUE) {
        echo "Data updated successfully";
    } else {
        echo "Error updating data: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request";
}
?>
<!-- Add this script to include jQuery -->
<script src="C:\xampp\jquery.js"></script>

<script>
    function saveInfo(field) {
        const newValue = document.getElementById(field).innerText;
        document.getElementById(field).contentEditable = false;
        document.querySelector(`button[onclick="editInfo('${field}')"]`).style.display = 'block';
        document.querySelector(`button[onclick="saveInfo('${field}')"]`).style.display = 'none';

        // Perform AJAX request to update the value in the database
        $.ajax({
            type: "POST",
            url: "update_profile.php",
            data: { field: field, value: newValue },
            success: function(response) {
                alert(response);
            }
        });
    }
</script>

