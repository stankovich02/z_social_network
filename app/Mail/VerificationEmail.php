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
            self::$mail->Body    = "Click the button below to verify your email: <br><br>
                              <a style='padding: 10px 50px;border-radius: 10px;margin-bottom: 20px;font-size: 17px;text-align: center;background-color: #009dff;text-decoration: none;color: #ffffff;' href='$verificationLink'>Click here</a>";
            self::$mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {" . self::$mail->ErrorInfo . "}";
        }

    }
}