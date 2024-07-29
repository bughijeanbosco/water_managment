<?php
require 'config.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $newPassword = $_POST['password'];

    if (empty($token) || empty($newPassword)) {
        die("Invalid request");
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

    // Hash new password
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Update password in database
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("ss", $hashedPassword, $email);
    $stmt->execute();

    // Delete the reset token
    $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("s", $token);
    $stmt->execute();

    echo "Password has been updated successfully.";
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
