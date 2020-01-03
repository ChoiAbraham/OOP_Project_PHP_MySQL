<?php

namespace App\Controllers\Traits;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Helper\ValidationForm\Login\AbstractLogin;

trait CoreTrait
{
    public function getTwig()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../../templates');

        $twig = new Environment($loader);

        //Check if the user is logged-in
        $log = new AbstractLogin();
        $log->setIsLoggedIn();
        if ($log->getData()) {
            $userObject = $log->getData();
        } else {
            $userObject = '';
        }

        $twig->addGlobal('user', $userObject);
        return $twig;
    }
}
