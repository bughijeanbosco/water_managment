<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = "";     // Replace with your MySQL password
$database = "smartwatermanagement2"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM water_level WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: ".$_SERVER['PHP_SELF']); // Redirect to avoid resubmission
    exit();
}

// Handle update action
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $tank_id = $conn->real_escape_string($_POST['tank_id']);
    $location = $conn->real_escape_string($_POST['location']);
    $water_level = intval($_POST['water_level']);
    $reading_time = $conn->real_escape_string($_POST['reading_time']);

    $stmt = $conn->prepare("UPDATE water_level SET tank_id = ?, location = ?, water_level = ?, reading_time = ? WHERE id = ?");
    $stmt->bind_param("ssisi", $tank_id, $location, $water_level, $reading_time, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: ".$_SERVER['PHP_SELF']); // Redirect to avoid resubmission
    exit();
}

// Fetch data from the water_level table
$sql = "SELECT * FROM water_level";
$result = $conn->query($sql);

// Start HTML output
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Level Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(45deg, #dce35b, #45b649);
            background-size: 400% 400%;
            animation: backgroundShift 10s ease infinite;
        }
        .container {
            max-width: 1200px;
            width: 100%;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #f3f;
            text-align: center;
            animation: pulse 2s infinite;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .btn {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
            animation: float 2s ease-in-out infinite;
        }
        .btn-danger {
            background-color: #DC3545;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0); }
        }
        @keyframes backgroundShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>All Data Available in All Tanks</h1>
        <h2>Monitor and Manage Your Water Tanks Efficiently</h2>

        <div style="text-align: center;">
            <a href="home2.html" class="btn btn-secondary">Back to Home</a>
        </div>

        <!-- Update Form -->
        <?php if (isset($_GET['edit_id'])): ?>
            <?php
            $edit_id = intval($_GET['edit_id']);
            $stmt = $conn->prepare("SELECT * FROM water_level WHERE id = ?");
            $stmt->bind_param("i", $edit_id);
            $stmt->execute();
            $result_edit = $stmt->get_result();
            $row_edit = $result_edit->fetch_assoc();
            $stmt->close();
            ?>
            <h2>Update Record</h2>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row_edit['id']); ?>">
                <div class="form-group">
                    <label for="tank_id">Tank ID:</label>
                    <input type="text" name="tank_id" id="tank_id" value="<?php echo htmlspecialchars($row_edit['tank_id']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" name="location" id="location" value="<?php echo htmlspecialchars($row_edit['location']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="water_level">Water Level:</label>
                    <input type="number" name="water_level" id="water_level" value="<?php echo htmlspecialchars($row_edit['water_level']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="reading_time">Reading Time:</label>
                    <input type="datetime-local" name="reading_time" id="reading_time" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($row_edit['reading_time']))); ?>" required>
                </div>
                <button type="submit" name="update" class="btn">Update Record</button>
            </form>
        <?php endif; ?>

        <!-- Display Data -->
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tank ID</th>
                        <th>Location</th>
                        <th>Water Level</th>
                        <th>Reading Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['tank_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                            <td><?php echo htmlspecialchars($row['water_level']); ?></td>
                            <td><?php echo htmlspecialchars($row['reading_time']); ?></td>
                            <td>
                                <a href="?edit_id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                                <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No data found.</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </div>
</body>
</html>
