<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Management Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="table-container">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = ""; // Replace with your actual MySQL password
        $dbname = "smartwatermanagement2";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch data from water_level table
        $sql = "SELECT tank_id, location FROM water_level ORDER BY tank_id, location";
        $result = $conn->query($sql);

        // Check if query was successful
        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Create a unique key for each combination of tank_id and location
                $key = $row['tank_id'] . '-' . $row['location'];
                if (!isset($data[$key])) {
                    $data[$key] = $row; // Store the first occurrence of each unique combination
                }
            }
        }

        $conn->close();

        // Display the data in table format
        echo "<table>
                <tr>
                    <th>Tank ID</th>
                    <th>Location</th>
                </tr>";

        foreach ($data as $record) {
            echo "<tr>
                    <td>" . $record['tank_id'] . "</td>
                    <td>" . $record['location'] . "</td>
                  </tr>";
        }

        echo "</table>";
        ?>
    </div>
</body>
</html>
