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
    protected $sessionName;
    protected $cookieName;
    protected $data;

    protected $userRepository;
    protected $sessionRepository;

    public function __construct()
    {
        $factoryRepository = App::getInstance();
        $this->sessionRepository = $factoryRepository->getRepository('session');
        $this->userRepository = $factoryRepository->getRepository('user');
        $this->sessionName = Config::get('session/session_name');
        $this->cookieName = Config::get('remember/cookie_name');
    }

    /**
     * if Cookie exists (user has checked remember-me and it created a cookie), and also the Session doesn't exist
     * then log-in the user automatically
     * else if Cookie/session doesn't exist, logout
     */
    public function rememberMe()
    {
        if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
            //get the hash from the Cookie
            $hash = Cookie::get(Config::get('remember/cookie_name'));
            //get the hash from the database
            $hashCheck = $this->sessionRepository->findHash($hash);

            //if hash matches, log in the user
            if ($hashCheck) {
                $log = new LoginUser();
                $log->setIsLoggedIn($hashCheck->getUserId());
            }
        } elseif (!Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
            $this->logout();
        }
    }

    /**
     * Check if user is logged-in with $_SESSION['user']
     * @param [int] $userId
     * @return  Object User data user
     */
    public function setIsLoggedIn($userId = '')
    {
        //if the userID is not specified (default userID) we get the userId stored in the $_SESSION['user']
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
        if (Session::exists('role')) {
            Session::delete('role');
        } elseif (Session::exists($this->sessionName)) {
            $id = Session::get($this->sessionName);
            $this->sessionRepository->deleteHashByUserId($id);
        }

        Session::delete($this->sessionName);
        Cookie::delete($this->cookieName);
    }

    public function isAdmin()
    {
        if (Session::exists('role') && Session::get('role') === 'admin') {
            return true;
        } else {
            return false;
        }
    }
}
