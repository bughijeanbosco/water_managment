<?php
require 'config.php'; // Include your database connection

$token = $_GET['token'];

if (empty($token)) {
    die("Invalid token");
}

$stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ? AND expiry > NOW()");
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    die("Invalid or expired token");
}

$stmt->bind_result($email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="styles2.css">
</head>
<body>
    <header>
        <h2>Reset Password</h2>
    </header>

    <main>
        <h3>Reset Password</h3>
        <form action="update_password.php" method="post">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Update Password</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 SmartWaterManagement_with_machine_Learning</p>
    </footer>
</body>
</html>
