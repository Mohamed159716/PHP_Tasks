<?php
function sendMail($subject, $body, $email) {
    $to_email = "mohamed3579340@gmail.com";
    $subject = $subject;
    $body = $body;
    $headers = $email;

    if (mail($to_email, $subject, $body, $headers)) {
        echo "Email successfully sent to $to_email...";
    } else {
        echo "Email sending failed...";
    }

    header('Location: index.php');
    die();
}