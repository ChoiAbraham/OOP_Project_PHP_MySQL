<?php

use App\Application\Config;
use App\Repository\sessionRepository;

use App\Helper\ValidationForm\Cookie;
use App\Helper\ValidationForm\Session;
use App\Helper\ValidationForm\Login\AbstractLogin;

$GLOBALS['config'] = array(
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token',
        'key' => 'key'
    )
);

/**
 * if Cookie exists (user has checked remember-me and it created a cookie), and the Session doesn't eixst
 * then log-in the user
 */
if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $repo = new sessionRepository();
    $hashCheck = $repo->findHash($hash);

    //if hash matches, log in the user
    if ($hashCheck) {
        $log = new LoginUser();
        $log->setIsLoggedIn($hashCheck->getUserId());
    }
} elseif (!Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
    $log = new AbstractLogin();
    $log->logout();
}
