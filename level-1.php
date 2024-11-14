<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Mailtrap configuration
    $to = "your_inbox@inbox.mailtrap.io";
    $subject = "New Contact Form Submission";
    $headers = "From: " . $email;

    $body = "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Message:\n$message";

    if (mail($to, $subject, $body, $headers)) {
        echo "Email successfully sent to $to...";
    } else {
        echo "Email sending failed...";
    }
}
?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // Mailtrap configuration
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = 'TODO';
        $mail->Password = 'TODO';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 2525;

        // Email settings
        $mail->setFrom($email, $name);
        $mail->addAddress('your_inbox@inbox.mailtrap.io');
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body = "Name: $name\nEmail: $email\nMessage:\n$message";

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
</head>
<body>
    <form action="" method="POST">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <label for="message">Message:</label><br>
        <textarea id="message" name="message" required></textarea><br><br>
        <button type="submit">Send</button>
    </form>
</body>
</html>
