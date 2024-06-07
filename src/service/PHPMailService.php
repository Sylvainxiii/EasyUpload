<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;

class PHPMailService extends PHPMailer
{
    public function __construct()
    {
        //configuration
        $this->isSMTP();                                            //Send using SMTP
        $this->CharSet = "UTF-8";
        $this->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->Host       = $_ENV['MAIL_HOST'];                     //Set the SMTP server to send through
        $this->Username   = $_ENV['MAIL_USERNAME'];                     //SMTP username
        $this->Password   = $_ENV['MAIL_PASSWORD'];                               //SMTP password
        $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $this->Port       = $_ENV['MAIL_PORT'];
        $this->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
    }
}