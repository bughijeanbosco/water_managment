<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'smartwatermanagement2');
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
    if ($stmt === false) {
        die("Error preparing statement: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: home.html");
        exit(); // Ensure script stops execution after redirection
    } else {
        $_SESSION['login_error'] = "Invalid username or password";
        header("Location: index.html");
        exit(); // Ensure script stops execution after redirection
    }

    $conn->close();
}
?>
