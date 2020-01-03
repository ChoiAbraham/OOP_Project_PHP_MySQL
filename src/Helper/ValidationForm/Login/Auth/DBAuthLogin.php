<?php

namespace App\Helper\ValidationForm\Login\Auth;

use App\Core\App;
use App\Application\Config;
use App\Helper\ValidationForm\Login\AbstractLogin;
use App\Helper\ValidationForm\Session;
use App\Helper\ValidationForm\Hash;
use App\Helper\ValidationForm\Cookie;

/*
 * Login Admin
 * Check if admin in database and admin password
 * if success, login, create $_SESSION['auth']
 */
class DBAuthLogin extends AbstractLogin
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

    public function loginAdmin($remember, $username = null, $password = null)
    {
        $this->data = $this->userRepository->findByUsername($username);

        if ($this->data) {
            $bool = $this->data->getRole() === 'admin';
            if ($bool) {
                if ($this->data->getPassword() === Hash::make($password, $this->data->getSalt())) {
                    Session::put($this->sessionName, $this->data->getId());
                    Session::put('auth', $this->data->getId());

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
            Session::flash('adminrequired', 'You need to be an Admin');
        }
    }
}
