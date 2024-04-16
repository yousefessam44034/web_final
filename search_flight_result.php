<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">

  <title>Flight Search Results</title>
  <style>
    

    strong {
      font-weight: bold; 
    }

    em {
      font-style: italic; 
    }

    table {
      background: #f5f5f5;
      border-collapse: separate;
      box-shadow: inset 0 1px 0 #fff;
      font-size: 12px;
      line-height: 24px;
      margin: 30px auto;
      text-align: left;
      width: 800px;
    } 

    th {
      background: url(https://jackrugile.com/images/misc/noise-diagonal.png), linear-gradient(#777, #444);
      border-left: 1px solid #555;
      border-right: 1px solid #777;
      border-top: 1px solid #555;
      border-bottom: 1px solid #333;
      box-shadow: inset 0 1px 0 #999;
      color: #fff;
      font-weight: bold;
      padding: 10px 15px;
      position: relative;
      text-shadow: 0 1px 0 #000;  
    }

    th:after {
      background: linear-gradient(rgba(255,255,255,0), rgba(255,255,255,.08));
      content: '';
      display: block;
      height: 25%;
      left: 0;
      margin: 1px 0 0 0;
      position: absolute;
      top: 25%;
      width: 100%;
    }

    th:first-child {
      border-left: 1px solid #777;  
      box-shadow: inset 1px 1px 0 #999;
    }

    th:last-child {
      box-shadow: inset -1px 1px 0 #999;
    }

    td {
      border-right: 1px solid #fff;
      border-left: 1px solid #e8e8e8;
      border-top: 1px solid #fff;
      border-bottom: 1px solid #e8e8e8;
      padding: 10px 15px;
      position: relative;
      transition: all 300ms;
    }

    td:first-child {
      box-shadow: inset 1px 0 0 #fff;
    } 

    td:last-child {
      border-right: 1px solid #e8e8e8;
      box-shadow: inset -1px 0 0 #fff;
    } 

    tr {
      background: url(https://jackrugile.com/images/misc/noise-diagonal.png); 
    }

    tr:nth-child(odd) td {
      background: #f1f1f1 url(https://jackrugile.com/images/misc/noise-diagonal.png); 
    }

    tr:last-of-type td {
      box-shadow: inset 0 -1px 0 #fff; 
    }

    tr:last-of-type td:first-child {
      box-shadow: inset 1px -1px 0 #fff;
    } 

    tr:last-of-type td:last-child {
      box-shadow: inset -1px -1px 0 #fff;
    } 

    tbody:hover td {
      color: transparent;
      text-shadow: 0 0 3px #aaa;
    }

    tbody:hover tr:hover td {
      color: #444;
      text-shadow: 0 1px 0 #fff;
    }
  </style>
</head>
<body>
  
  <?php
  // Assume you have a MySQL database connection
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "webprojectdb";
  session_start();

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  // Process search form submission
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $itinerary = $_POST['itinerary'];

      // Perform a query to get the list of available flights based on the search criteria
      $sql = "SELECT * FROM flight WHERE itinerary LIKE '%$itinerary%'";
      $result = $conn->query($sql);

      if ($result) {
          if ($result->num_rows > 0) {
              // Display the list of available flights
              echo "<h2>Available Flights</h2>";
              echo "<table>";
              echo "<tr><th>ID</th><th>Name</th><th>Itinerary</th><th>Fees</th><th>Registered Passengers</th><th>Pending Passengers</th><th>Total Passengers</th><th>Start Time</th><th>End Time</th><th>Completed</th><th>Action</th></tr>";

              while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . (isset($row['ID']) ? $row['ID'] : '') . "</td>";
                  echo "<td>" . (isset($row['Name']) ? $row['Name'] : '') . "</td>";
                  echo "<td>" . (isset($row['Itinerary']) ? $row['Itinerary'] : '') . "</td>";
                  echo "<td>" . (isset($row['Fees']) ? $row['Fees'] : '') . "</td>";
                  echo "<td>" . (isset($row['RegisteredPassengers']) ? $row['RegisteredPassengers'] : '') . "</td>";
                  echo "<td>" . (isset($row['PendingPassengers']) ? $row['PendingPassengers'] : '') . "</td>";
                  echo "<td>" . (isset($row['TotalPassengers']) ? $row['TotalPassengers'] : '') . "</td>";
                  echo "<td>" . (isset($row['StartTime']) ? $row['StartTime'] : '') . "</td>";
                  echo "<td>" . (isset($row['EndTime']) ? $row['EndTime'] : '') . "</td>";
                  echo "<td>" . (isset($row['Completed']) ? $row['Completed'] : '') . "</td>";
                  echo "<td><a href='view_flight.php?id=" . (isset($row['Id']) ? $row['id'] : '') . "'>View Details</a></td>";
                  echo "<td><button onclick='bookTicket(" . $row['ID'] . ")'>Book Ticket</button></td>";
                  echo "</tr>";
              }

              echo "</table>";
          } else {
              echo "No flights found";
          }
      } else {
          die("Query failed: " . $conn->error);
      }
  }

  $conn->close();
  ?>

  <script>
    function bookTicket(flightId) {
      // You can use AJAX or fetch to send a request to the server to update the database
      // For simplicity, I'll use a basic URL redirection here
      window.location.href = "book_ticket.php?flightId=" + flightId;
    }
  </script>
</body>
