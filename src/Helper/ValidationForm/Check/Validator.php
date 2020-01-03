<?php

namespace App\Helper\ValidationForm\Check;

use App\Core\App;
use App\Helper\ValidationForm\Input;
use App\Helper\ValidationForm\Token;
use App\Helper\ValidationForm\Login;
use App\Helper\Factory\RepositoryFactory;

/*
 * Abstract Class for Validator classes
 */
class Validator extends RepositoryFactory
{
    // TODO: Controller : same method
    public function redirect($location = null)
    {
        if ($location) {
            $location = '/' . $location;
            header('Location:' . $location);
            exit();
        }
    }

    /**
     * Check the form method GET or POST,
     * if GET it generates a new token and create a $_SESSION['token'] (before form submission)
     * if POST (form submitted), it gets the token from the input name='token' from the form
     * @return string token
     */
    public function checkToken()
    {
        $token = $_SERVER['REQUEST_METHOD'] === 'GET' ? Token::generate() : Input::get('token');

        return $token;
    }

    /**
     * to prevent csrf (Cross Site Request Forgery)
     * if Input exists from the form (form submitted)
     * if the input token equals the token from the $_SESSION['token']
     * THEN calls the method
     * @param  string [method name]
     * @param  int    [User id]
     */
    public function csrfInput($functionName, $id = '')
    {
        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {
                if ($id) {
                    return static::$functionName($id);
                } else {
                    return static::$functionName();
                }
            }
        }
    }

    /**
     * Check if the user is Logged In,
     * IF YES, stores data user in $userObject
     * @return object User
     */
    public static function checkLogin()
    {
        $log = new Login();
        $log->setIsLoggedIn();
        if ($log->getData()) {
            $userObject = $log->getData();
        } else {
            $userObject = '';
        }

        return $userObject;
    }
}
