<?php

namespace App\Mail;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class VerificationEmail extends MailSender
{
    public string $token;
    public function __construct(string $token){
        $this->token = $token;
    }
    public function sendEmail($toEmail)
    {
        parent::sendEmail($toEmail);
        try {
            $verificationLink = "http://localhost:8080/verification/" . $this->token;
            self::$mail->Subject = 'Verification Email';
            self::$mail->Body    = "Click the link below to verify your email: <br><br>
                              <a href='$verificationLink'>$verificationLink</a>";
            self::$mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {" . self::$mail->ErrorInfo . "}";
        }

    }
}