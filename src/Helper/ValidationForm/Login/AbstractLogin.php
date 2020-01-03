<?php

namespace App\Helper\ValidationForm\Login;

use App\Core\App;
use App\Repository\UserRepository;
use App\Repository\SessionRepository;
use App\Application\Config;
use App\Helper\ValidationForm\Session;
use App\Helper\ValidationForm\Hash;
use App\Helper\ValidationForm\Cookie;

/**
 * Abstract Class for login Admin and login User
 */
class AbstractLogin
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

    /**
     * Check if user is logged-in with $_SESSION['user']
     * @param [int] $userId
     * @return  Object User data user
     */
    public function setIsLoggedIn($userId = null)
    {
        if (!$userId) {
            if (Session::exists($this->sessionName)) {
                $id = Session::get($this->sessionName);

                $this->data = $this->userRepository->findById($id);
            }
        } else {
            $this->data = $this->userRepository->findById($userId);
            Session::put($this->sessionName, $this->data->getId());
        }
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * logout User/Admin
     * delete Session/Cookie
     * @param $id
     */
    public function logout($id = '')
    {
        if (Session::exists('auth')) {
            Session::delete('auth');
        } elseif (Session::exists($this->sessionName)) {
            $id = Session::get($this->sessionName);
            $this->sessionRepository->deleteHashByUserId($id);
        }

        Session::delete($this->sessionName);
        Cookie::delete($this->cookieName);
    }
}
