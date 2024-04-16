<!-- search_flight.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Search Flights</title>
</head>
<?php
session_start();
if (isset($_SESSION['email'])) {
    // ... (your existing code)
} else {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}
?>
<body>
    
    <div class="container">
        <div id="search-flight" class="page">
            <h2>Search Flights</h2>
            <!-- Your search form goes here -->
            <form action="search_flight_result.php" method="post" id="searchForm">
                <label for="itinerary">Itinerary:</label>
                <input type="text" id="itinerary" name="itinerary" required>
                <br> <br>

                <button type="submit">Search</button>
            </form>
        </div>
    </div>
</body>

</html>
