<?php

namespace models;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

require_once __DIR__ . "/../public/plugins/phpmailer/PHPMailer.php";
require_once __DIR__ . "/../public/plugins/phpmailer/SMTP.php";
require_once __DIR__ . "/../public/plugins/phpmailer/Exception.php";

class Phpmailers {
    // Function to send OTP email using PHPMailer
    public function sendOTPEmail($email, $messages, $subject) {

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "lageraallan44@gmail.com";
            $mail->Password = 'ecdcklcstdfaywes';
            $mail->Port = 587;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            $mail->isHTML(true);
            $mail->setFrom('lageraallan44@gmail.com', "Lending MS"); // Change to your email
            $mail->addAddress($email);
            $mail->Subject = $subject;
            $mail->Body = $messages;

            if(!$mail->send()) {
                throw new \Exception("Error Processing PHPMAILER");
                
            }
            return true;
        } catch (\Throwable $th) {
            return[
                'error' => true,
                'message' => $th->getMessage()
            ];
        }
    }
}


?>