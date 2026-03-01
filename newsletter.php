<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if (!$email) {
        echo "<script>
            alert('Please enter a valid email address.');
            window.location.href = 'index.php';
        </script>";
        exit;
    }

    try {

        /* ================= EMAIL ADMIN ================= */

        $mailAdmin = new PHPMailer(true);

        $mailAdmin->isSMTP();
        $mailAdmin->Host       = 'smtp.hostinger.com';
        $mailAdmin->SMTPAuth   = true;
        $mailAdmin->Username   = 'contact@precisionlawfirm.net';
        $mailAdmin->Password   = '6H9[=6T#v';
        $mailAdmin->SMTPSecure = 'tls';
        $mailAdmin->Port       = 587;

        $mailAdmin->setFrom('contact@precisionlawfirm.net', 'Precision Law Firm');
        $mailAdmin->addAddress('contact@precisionlawfirm.net');

        $mailAdmin->isHTML(true);
        $mailAdmin->Subject = 'New Newsletter Subscription';
        $mailAdmin->Body    = "
            <h3>New Newsletter Subscription</h3>
            <p>Email: <strong>$email</strong></p>
        ";

        $mailAdmin->send();


        /* ================= EMAIL SUBSCRIBER ================= */

        $mailUser = new PHPMailer(true);

        $mailUser->isSMTP();
        $mailUser->Host       = 'smtp.hostinger.com';
        $mailUser->SMTPAuth   = true;
        $mailUser->Username   = 'contact@precisionlawfirm.net';
        $mailUser->Password   = '6H9[=6T#v';
        $mailUser->SMTPSecure = 'tls';
        $mailUser->Port       = 587;

        $mailUser->setFrom('contact@precisionlawfirm.net', 'Precision Law Firm');
        $mailUser->addAddress($email);

        $mailUser->isHTML(true);
        $mailUser->Subject = 'Subscription Confirmed ✔';

        $mailUser->Body = "
            <h2>Welcome 👋</h2>
            <p>Thank you for subscribing to our newsletter.</p>
            <p>You will now receive updates from <strong>Precision Law Firm</strong>.</p>
            <br>
            <p>Best regards,<br>Precision Law Firm Team</p>
        ";

        $mailUser->send();


        /* ================= SUCCESS ================= */

        echo "<script>
            alert('Thank you! Your email has been successfully added to the newsletter.');
            window.location.href = 'index.php';
        </script>";
        exit;

    } catch (Exception $e) {

        $error = addslashes($e->getMessage());

        echo "<script>
            alert('An error occurred: $error');
            window.location.href = 'index.php';
        </script>";
        exit;
    }

} else {
    header("Location: index.php");
    exit;
}
?>