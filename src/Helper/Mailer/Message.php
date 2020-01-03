<?php

namespace App\Helper\Mailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Message
{
    protected $mailer;

    public function __construct(PHPMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function to($address, $name = '')
    {
        $this->mailer->addAddress($address, $name);
    }

    public function subject($subject)
    {
        $this->mailer->Subject = $subject;
    }

    public function body($body)
    {
        $this->mailer->Body = $body;
    }

    public function setFrom($email, $title)
    {
        $this->mailer->setFrom($email, $title);
    }

    public function replyTo($email, $info)
    {
        $this->mailer->addReplyTo($email, $info);
    }
}
