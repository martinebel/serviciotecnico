<?php
require 'PHPMailer/PHPMailerAutoload.php';

function sendMail($destino,$nombre,$asunto,$mensaje){

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'ventas@ryrcomputacion.com';                 // SMTP username
$mail->Password = 'Ventasryr2016';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('ventas@ryrcomputacion.com', 'RyR Computacion');
$mail->addAddress($destino, $nombre);     // Add a recipient              // Name is optional


/*$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name*/
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $asunto;
$mail->Body    = $mensaje;
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
$mail->send();
/*if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}*/
}
?>