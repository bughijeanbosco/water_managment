<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanks Available Now</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #a2c2e0, #f0f0f0);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            animation: backgroundShift 15s ease infinite;
        }
        .container {
            width: 90%;
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 2s ease-in;
        }
        h2 {
            margin-bottom: 20px;
            color: #f3f;
            animation: pulse 2s infinite;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #007BFF;
            font-size: 18px;
            transition: color 0.3s, transform 0.3s;
        }
        .back-link:hover {
            color: #0056b3;
            transform: scale(1.05);
        }
        .search-container {
            margin-bottom: 20px;
        }
        .search-container input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
        }
        .search-container input:focus {
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        @keyframes backgroundShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.03); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="home2.html" class="back-link">Go to Home</a>
        <h2>Tanks Available Now</h2>
        <p>If you can't find any tank, make sure it is working.</p>
        <div class="search-container">
            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for locations..">
        </div>
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
            $sql = "SELECT tank_id, LOWER(location) AS location FROM water_level ORDER BY tank_id, location";
            $result = $conn->query($sql);

            // Check if query was successful
            if (!$result) {
                die("Query failed: " . $conn->error);
            }

            $data = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Create a unique key for each combination of tank_id and lowercased location
                    $key = $row['tank_id'] . '-' . strtolower($row['location']);
                    if (!isset($data[$key])) {
                        $data[$key] = $row; // Store the first occurrence of each unique combination
                    }
                }
            }

            $conn->close();

            // Display the data in table format
            echo "<table id='dataTable'>
                    <thead>
                        <tr>
                            <th>Tank ID</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>";

            foreach ($data as $record) {
                echo "<tr>
                        <td>" . $record['tank_id'] . "</td>
                        <td>" . ucfirst($record['location']) . "</td>
                      </tr>";
            }

            echo "    </tbody>
                  </table>";
            ?>
        </div>
    </div>
    <script>
        function searchTable() {
            let input = document.getElementById('searchInput');
            let filter = input.value.toLowerCase();
            let table = document.getElementById('dataTable');
            let tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                let td = tr[i].getElementsByTagName('td')[1];
                if (td) {
                    let txtValue = td.textContent || td.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }
    </script>
</body>
</html>
