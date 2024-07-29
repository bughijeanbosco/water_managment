<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Display with CRUD Operations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 6px 10px;
            text-decoration: none;
            background-color: #f0f0f0;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn-delete {
            background-color: #f44336;
            color: white;
        }
        .btn-update {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
<form>
<h2>Data from smartwatermanagement2 Table</h2>
<h2><a href="index.html">BackToIndex</a></h2></form>
<?php

// Database connection parameters
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "smartwatermanagement2"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Delete Request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_delete = "DELETE FROM water_level WHERE tank_id = $id";
    if ($conn->query($sql_delete) === TRUE) {
        echo "<p>Record deleted successfully.</p>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Handle Update Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $location = $_POST['location'];
    $water_level = $_POST['water_level'];
    $reading_time = $_POST['reading_time'];

    $sql_update = "UPDATE water_level SET location='$location', water_level=$water_level, reading_time='$reading_time' WHERE tank_id=$id";
    if ($conn->query($sql_update) === TRUE) {
        echo "<p>Record updated successfully.</p>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// SQL query to fetch all data from the table
$sql_select = "SELECT tank_id, location, water_level, reading_time FROM water_level";
$result = $conn->query($sql_select);

if ($result->num_rows > 0) {
    // Output data of each row
    echo "<table>";
    echo "<tr><th>Tank ID</th><th>Location</th><th>Water Level</th><th>Reading Time</th><th>Actions</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["tank_id"] . "</td>";
        echo "<td>" . $row["location"] . "</td>";
        echo "<td>" . $row["water_level"] . "</td>";
        echo "<td>" . $row["reading_time"] . "</td>";
        echo "<td>";
        echo '<a href="?action=delete&id=' . $row["tank_id"] . '" class="btn btn-delete">Delete</a>';
        echo ' <a href="#" onclick="showUpdateForm(' . $row["tank_id"] . ', \'' . $row["location"] . '\', ' . $row["water_level"] . ', \'' . $row["reading_time"] . '\')" class="btn btn-update">Update</a>';
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();

?>

<!-- Update Form -->
<div id="updateForm" style="display:none;">
    <h3>Update Record</h3>
    <form method="post">
        <input type="hidden" id="update_id" name="id" value="">
        <label for="update_location">Location:</label><br>
        <input type="text" id="update_location" name="location" required><br>
        <label for="update_water_level">Water Level:</label><br>
        <input type="number" id="update_water_level" name="water_level" required><br>
        <label for="update_reading_time">Reading Time:</label><br>
        <input type="datetime-local" id="update_reading_time" name="reading_time" required><br><br>
        <input type="submit" name="update" value="Update">
        <button type="button" onclick="hideUpdateForm()">Cancel</button>
    </form>
</div>

<script>
    function showUpdateForm(id, location, waterLevel, readingTime) {
        document.getElementById('update_id').value = id;
        document.getElementById('update_location').value = location;
        document.getElementById('update_water_level').value = waterLevel;
        document.getElementById('update_reading_time').value = readingTime.replace(' ', 'T');
        document.getElementById('updateForm').style.display = 'block';
    }

    function hideUpdateForm() {
        document.getElementById('updateForm').style.display = 'none';
    }
</script>

</body>
</html>
