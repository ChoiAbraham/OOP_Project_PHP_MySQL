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
    public function login($remember, $username = null, $password = null)
    {
        $this->data = $this->userRepository->findByUsername($username);

        if ($this->data) {
            if ($this->data->getPassword() === Hash::make($password, $this->data->getSalt())) {
                Session::put($this->sessionName, $this->data->getId());

                //if User has clicked on "remember-me"
                if ($remember) {
                    //User ID
                    $id = $this->data->getId();

                    //check if hash exist for the user
                    $hashCheck = $this->sessionRepository->findByUserId($id);

                    //if not we create one and insert it
                    //if yes we retrieve it
                    if (!$hashCheck) {
                        $hash = hash('sha256', uniqid());
                        $this->sessionRepository->insertHashSession($hash, $id);
                    } else {
                        $hash = $hashCheck->getHash();
                    }

                    //create cookie with hash
                    //only in logout the cookie will be deleted
                    Cookie::put($this->cookieName, $hash, Config::get('remember/cookie_expiry'));
                }

                return true;
            }
            return false;
        }
    }
}
