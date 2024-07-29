<!-- forgot_password.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="styles2.css">
</head>
<body>
    <header>
        <h2>Forgot Password</h2>
    </header>

    <main>
        <h3>Forgot Password</h3>
        <form action="send_reset_link.php" method="post">
            <label for="email">Enter your email address:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Send Reset Link</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 SmartWaterManagement_with_machine_Learning</p>
    </footer>
</body>
</html>
