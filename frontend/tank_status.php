<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SmartWaterManagement";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Tanks.tank_id, Tanks.location, WaterLevels.water_level, WaterLevels.reading_time
        FROM Tanks
        JOIN Sensors ON Tanks.tank_id = Sensors.tank_id
        JOIN WaterLevels ON Sensors.sensor_id = WaterLevels.sensor_id
        ORDER BY WaterLevels.reading_time DESC
        LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>Tank ID</th><th>Location</th><th>Water Level (liters)</th><th>Reading Time</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["tank_id"]. "</td><td>" . $row["location"]. "</td><td>" . $row["water_level"]. "</td><td>" . $row["reading_time"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
?>
