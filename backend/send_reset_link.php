<?php
require 'config.php'; // Ensure this file exists in the same directory
require 'vendor/autoload.php'; // Autoload PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // Check if email exists in the database
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // Insert token into database
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expiry) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("sss", $email, $token, $expiry);
        $stmt->execute();

        // Send email with reset link
        $resetLink = "http://yourdomain.com/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: $resetLink";

        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'bugiruwendaj@gmail.com'; // SMTP username
            $mail->Password = 'Bughi@123'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption
            $mail->Port = 587; // TCP port to connect to

            //Recipients
            $mail->setFrom('no-reply@yourdomain.com', 'Water Tank Level Detection');
            $mail->addAddress($email); // Add a recipient

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
            echo "A password reset link has been sent to your email address.";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "No account found with that email address.";
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
