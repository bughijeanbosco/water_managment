<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Display with CRUD Operations and Chart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 10px;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 6px 12px;
            text-decoration: none;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-delete {
            background-color: #f44336;
        }
        .btn-update {
            background-color: #4CAF50;
        }
        #updateForm {
            display: none;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }
        #updateForm input[type="text"],
        #updateForm input[type="number"],
        #updateForm input[type="datetime-local"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 5px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        #updateForm input[type="submit"],
        #updateForm button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s;
        }
        #updateForm input[type="submit"] {
            background-color: #4CAF50;
            color: white;
        }
        #updateForm button {
            background-color: #f44336;
            color: white;
        }
        #updateForm input[type="submit"]:hover {
            background-color: #45a049;
        }
        #updateForm button:hover {
            background-color: #e60000;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #007BFF;
            transition: color 0.3s;
        }
        .back-link:hover {
            color: #0056b3;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-weight: bold;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h2>Tanks available now if you can't find any tank make sure it is working</h2>
        <h2>Here is each tank with its last entry data as the level of water in your tanks</h2>
        <a href="home2.html" class="back-link">Back to Home</a>

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
            $id = intval($_GET['id']);
            $sql_delete = "DELETE FROM water_level WHERE id = $id";
            if ($conn->query($sql_delete) === TRUE) {
                echo "<p class='message success'>Record deleted successfully.</p>";
            } else {
                echo "<p class='message error'>Error deleting record: " . $conn->error . "</p>";
            }
            echo "<script>setTimeout(function() { window.location.href = 'dashboard.php'; }, 2000);</script>";
            exit();
        }

        // Handle Update Request
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $id = intval($_POST['id']);
            $location = $conn->real_escape_string($_POST['location']);
            $water_level = intval($_POST['water_level']);
            $reading_time = $conn->real_escape_string($_POST['reading_time']);

            $sql_update = "UPDATE water_level SET location='$location', water_level=$water_level, reading_time='$reading_time' WHERE id=$id";
            if ($conn->query($sql_update) === TRUE) {
                echo "<p class='message success'>Record updated successfully.</p>";
            } else {
                echo "<p class='message error'>Error updating record: " . $conn->error . "</p>";
            }
            echo "<script>setTimeout(function() { window.location.href = 'dashboard.php'; }, 2000);</script>";
            exit();
        }

        // SQL query to fetch the latest record for each location
        $sql_select = "
            SELECT id, location, water_level, reading_time
            FROM (
                SELECT *,
                    ROW_NUMBER() OVER (PARTITION BY location ORDER BY reading_time DESC) AS rn
                FROM water_level
            ) AS subquery
            WHERE rn = 1
            ORDER BY location, reading_time DESC
        ";
        $result = $conn->query($sql_select);

        // Prepare data for Chart.js
        $locations = [];
        $water_levels = [];
        $reading_times = [];

        if ($result->num_rows > 0) {
            // Output data of each row
            echo "<table>";
            echo "<tr><th>ID</th><th>Location</th><th>Water Level</th><th>Reading Time</th><th>Actions</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["location"] . "</td>";
                echo "<td>" . $row["water_level"] . "</td>";
                echo "<td>" . $row["reading_time"] . "</td>";
                echo "<td>";
                echo '<a href="?action=delete&id=' . $row["id"] . '" class="btn btn-delete">Delete</a>';
                echo ' <a href="#" onclick="showUpdateForm(' . $row["id"] . ', \'' . $row["location"] . '\', ' . $row["water_level"] . ', \'' . $row["reading_time"] . '\')" class="btn btn-update">Update</a>';
                echo "</td>";
                echo "</tr>";

                // Collect data for Chart.js
                $locations[] = $row["location"];
                $water_levels[] = $row["water_level"];
                $reading_times[] = $row["reading_time"];
            }
            echo "</table>";
        } else {
            echo "<p>No results found.</p>";
        }

        // Close connection
        $conn->close();
        ?>

        <!-- Update Form -->
        <div id="updateForm">
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

        <!-- Chart.js Canvas -->
        <canvas id="waterLevelChart" width="400" height="200"></canvas>

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

        // Data for Chart.js
        var locations = <?php echo json_encode($locations); ?>;
        var waterLevels = <?php echo json_encode($water_levels); ?>;
        var readingTimes = <?php echo json_encode($reading_times); ?>;

        // Chart.js Initialization
        var ctx = document.getElementById('waterLevelChart').getContext('2d');
        var waterLevelChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: locations,
                datasets: [{
                    label: 'Water Level',
                    data: waterLevels,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
