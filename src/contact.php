<?php

//Get Values
$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];


require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

$mail->isSMTP();  //checks if it's an SMTP server
$mail->SMTPAuth = true; // set SMTP Authentication to true

// Gmail SMTP server
// 1. SMTP server address: smtp.gmail.com
// 2. Gmail SMTP port (TLS): 587
// 3. Gmail SMTP username and password also required

$mail->Host = "smtp.gmail.com"; // 1
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587; //2

$mail->Username = "jadalichahine@gmail.com"; //3
$mail->Password = "osex whli bzri hywr"; //3

$mail->setFrom($email);
$mail->addAddress("jadalichahine@gmail.com");
$mail->addReplyTo($email, $name);

$mail->Subject = $subject; // Add the subject to the mail subject
$mail->Body = $message; // Add the body to the mail body

$mail->send();

?>

