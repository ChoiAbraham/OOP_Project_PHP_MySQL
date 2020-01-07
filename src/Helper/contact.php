<?php

use App\Helper\Mailer\Mailer;
use App\Helper\ValidationForm\Session;

if (
    empty($_POST['name'])        ||
    empty($_POST['email'])       ||
    empty($_POST['phone'])       ||
    empty($_POST['message'])     ||
    !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
) {
    Session::flash('contactresponse', 'No arguments Provided');
    return;
}

$name = $_POST['name'];
$email = strip_tags(htmlspecialchars($_POST['email']));
$phone = $_POST['phone'];
$message = $_POST['message'];

//send email
$mail = new Mailer();

$mailInfo = include '../src/Application/mail.php';

$res = $mail->send(
    'mail/contact',
    [
        'name' => $name,
        'email' => $email,
        'message' => $message,
        'phone' => $phone
    ],
    $callback = function ($message) use ($email) {
        $message->setFrom($email, 'EMAIL FROM YOUR WEBSITE MYBLOG/');
        //addAddress
        $message->to($mailInfo['username']);
        $message->replyTo($email, '');
    }
);

Session::flash('contactresponse', 'Email sent');
