<?php

namespace App\Helper\ValidationForm;

use App\Application\Config;
use App\Helper\ValidationForm\Session;

class Token
{
    /*
     * return $_SESSION['token'] = md5(uniqid());
     */
    public static function generate()
    {
        return Session::put(Config::get('session/token_name'), md5(uniqid()));
    }

    public static function hashToken($token)
    {
        if (empty(Session::exists(Config::get('session/key')))) {
            Session::put(Config::get('session/key'), bin2hex(random_bytes(32)));
        }
        $csrf = hash_hmac('sha256', $token, $_SESSION['key']);

        return $csrf;
    }

    /*
     * check if token exists in the session
     * if the token equals the session that's being currently applied, then delete the session
     */
    public static function check($token)
    {
        $tokenName = Config::get('session/token_name');

        if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
            return true;
        }

        return false;
    }
}
