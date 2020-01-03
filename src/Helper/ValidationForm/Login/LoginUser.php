<?php

namespace App\Helper\ValidationForm\Login;

use App\Helper\ValidationForm\Login\AbstractLogin;
use App\Core\App;
use App\Repository\UserRepository;
use App\Repository\SessionRepository;
use App\Helper\Mailer\Mailer;
use App\Application\Config;
use App\Helper\ValidationForm\Session;
use App\Helper\ValidationForm\Hash;
use App\Helper\ValidationForm\Cookie;
use App\Helper\Mailer\Message;

class LoginUser extends AbstractLogin
{
    private $userRepository;
    private $sessionRepository;
    private $sessionName;
    private $cookieName;
    private $data;
    private $factoryRepository;

    public function __construct()
    {
        $this->factoryRepository = App::getInstance();

        $this->sessionName = Config::get('session/session_name');
        $this->cookieName = Config::get('remember/cookie_name');
        $this->userRepository = $this->factoryRepository->getRepository('user');
        $this->sessionRepository = $this->factoryRepository->getRepository('session');
    }

    public function login($remember, $username = null, $password = null)
    {
        $this->data = $this->userRepository->findByUsername($username);

        if ($this->data) {
            if ($this->data->getPassword() === Hash::make($password, $this->data->getSalt())) {
                Session::put($this->sessionName, $this->data->getId());

                if ($remember) {
                    $id = $this->data->getId();
                    $hashCheck = $this->sessionRepository->findByUserId($id);

                    if (!$hashCheck) {
                        $hash = hash('sha256', uniqid());
                        $this->sessionRepository->insertHash($hash, $id);
                    } else {
                        $hash = $hashCheck->getHash();
                    }

                    Cookie::put($this->cookieName, $hash, Config::get('remember/cookie_expiry'));
                }

                return true;
            }
            return false;
        }
    }

    /*
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Login;
        }

        return self::$instance;
    }
    */
}
