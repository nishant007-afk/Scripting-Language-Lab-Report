<!DOCTYPE html>
<html>
<head>
    <title>Send Email Notification</title>
</head>
<body>
    <h2>Send Email Notification</h2>
    <form method="post">
        Recipient Email: <input type="email" name="to" required><br><br>
        Subject: <input type="text" name="subject" required><br><br>
        Message:<br>
        <textarea name="message" rows="5" cols="40" required></textarea><br><br>
        <input type="submit" value="Send Notification">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $to = $_POST["to"];
        $subject = $_POST["subject"];
        $message = $_POST["message"];
        $headers = "From: nishantdahal0007@gmail.com\r\nReply-To: nishantdahal0007@gmail.com";

        if (mail($to, $subject, $message, $headers)) {
            echo "Email sent successfully to $to.";
        } else {
            echo "Failed to send email. Check SMTP settings.";
        }
    }
    ?>
</body>
</html>