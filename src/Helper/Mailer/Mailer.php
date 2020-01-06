<?php

namespace App\Helper\Mailer;

use App\Helper\Mailer\Message;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Core\Controller;

class Mailer extends Controller
{
    protected $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
    }

    public function send($view, $datas, $callback)
    {
        $mailInfo = include '../src/Application/mail.php';

        try {
            $this->mail->isSMTP();
            $this->mail->Host       = $mailInfo['host'];
            $this->mail->SMTPAuth   = $mailInfo['smtp_auth'];
            $this->mail->Username   = $mailInfo['username'];
            $this->mail->Password   = $mailInfo['password'];
            $this->mail->SMTPSecure = $mailInfo['smtp_secure'];
            $this->mail->Port       = $mailInfo['port'];
            $this->mail->isHTML($mailInfo['html']);

            $message = new Message($this->mail);

            $response = $this->renderResponse(
                $view . '.html.twig',
                $datas
            );

            $message->body($response);
            $returnValue = call_user_func($callback, $message);

            $this->mail->send();

            return 'Message has been sent';
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
