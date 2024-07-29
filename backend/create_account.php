<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <style>
        /* Add styles similar to the login page */
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h1 {
            font-size: 24px;
            color: #00796b;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="password"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #00796b;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create Account</h1>
        <form action="create_account.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="text" name="phone_number" placeholder="Phone Number" required>
            <button type="submit">Create Account</button><button type="cancel"><a href="index.html">cancel</a></button>
        </form>
    </div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'smartwatermanagement2');
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to insert the new user
    $sql = "INSERT INTO users (username, password, email, first_name, last_name, phone_number) 
            VALUES ('$username', '$password', '$email', '$first_name', '$last_name', '$phone_number')";

    if ($conn->query($sql) === TRUE) {
        echo "Account created successfully!";
        header("Location: index.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        header("Location: create_account.php");
    }

    $conn->close();
}
?>
