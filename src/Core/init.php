<?php

namespace App\Core;

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

$rememberMe = new AbstractLogin();
$rememberMe->rememberMe();
