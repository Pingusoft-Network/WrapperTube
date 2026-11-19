<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

function send_a_mail($toMail, $toName, $subject, $body) {

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'mail.wrappertube.org';
$mail->Port = 587;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->SMTPAuth = true;
$mail->Username = 'changeme'; //change this to your account username
$mail->Password = 'changeme'; //change this to your account password
$mail->setFrom('wrappertube@wrappertube.org', 'Wrapper Tube'); //change this to your contact email and your site name/domain
$mail->addAddress($toMail, $toName);
$mail->Subject = $subject;
$mail->Body = $body;

return $mail->send();

}
