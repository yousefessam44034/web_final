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
    $dbname = "webprojectdb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch user data based on the logged-in user's email
    $sql = "SELECT * FROM users WHERE email='$loggedInUserEmail'";
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
            <title>Passenger Profile</title>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }

                .container {
                    max-width: 600px;
                    margin: 50px auto;
                    background-color: #fff;
                    padding: 20px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    border-radius: 8px;
                }

                #passenger-profile {
                    text-align: center;
                }

                h2 {
                    color: #333;
                }

                p {
                    margin: 10px 0;
                }

                .editable {
                    display: inline-block;
                    padding: 5px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    cursor: pointer;
                }

                .edit-btn,
                .save-btn {
                    padding: 5px 10px;
                    margin-left: 10px;
                    cursor: pointer;
                    background-color: #4CAF50;
                    color: #fff;
                    border: none;
                    border-radius: 4px;
                    font-size: 14px;
                    transition: background-color 0.3s ease-in-out;
                }

                .edit-btn:hover,
                .save-btn:hover {
                    background-color: #45a049;
                }
            </style>
        </head>

        <body>
            <div class="container">
                <div id="passenger-profile" class="page">
                    <h2>Passenger Profile</h2>
                    <!-- Display user data within the HTML structure -->
                    <p>Name: <span id="name" class="editable" data-field="name"><?php echo $name; ?></span>
                        <button class="edit-btn">Edit</button>
                        <button class="save-btn" style="display: none;">Save</button>
                    </p>
                    <p>Email: <?php echo $email; ?></p>
                    <p>Phone Number: <span id="tel" class="editable" data-field="tel"><?php echo $tel; ?></span>
                        <button class="edit-btn">Edit</button>
                        <button class="save-btn" style="display: none;">Save</button>
                    </p>
                    <!-- Add more details or allow the user to edit their profile -->
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
            <script>
                $(document).ready(function () {
                    $(".edit-btn").click(function () {
                        var field = $(this).prev(".editable");
                        var editBtn = $(this);
                        var saveBtn = $(this).next(".save-btn");

                        // Make the content editable with animation
                        field.animate({ paddingLeft: "20px", paddingRight: "20px" }, 300, function () {
                            field.attr("contenteditable", "true");
                        });

                        // Toggle buttons
                        editBtn.hide();
                        saveBtn.show();
                    });

                    $(".save-btn").click(function () {
                        var field = $(this).prevAll(".editable");
                        var editBtn = $(this).prev(".edit-btn");
                        var saveBtn = $(this);

                        // Make the content non-editable
                        field.attr("contenteditable", "false").css({ paddingLeft: "5px", paddingRight: "5px" });

                        // Toggle buttons
                        editBtn.show();
                        saveBtn.hide();

                        // Perform AJAX request to update the value in the database
                        var newValue = field.text();
                        var fieldName = field.data("field");

                        $.ajax({
                            type: "POST",
                            url: "update_profile.php",
                            data: { field: fieldName, value: newValue },
                            success: function (response) {
                                alert(response);
                            }
                        });
                    });
                });
            </script>
        </body>

        </html>
        <?php
    } else {
        echo "User not found";
    }

    $conn->close();
} else {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}
?>
