<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helper\ValidationForm\Check\LogRegisterValidator;
use App\Helper\ValidationForm\Login\AbstractLogin;
use App\Helper\ValidationForm\Session;

/**
 * Register Page (both for admin and user)
 * Login User Page
 * Login Admin Page
 * Logout
 */
class LogRegister extends Controller
{
    protected $login;
    protected $logRegisterValidator;

    public function __construct()
    {
        if (!isset($this->login)) {
            $this->login = new AbstractLogin();
        }
        if (!isset($this->logRegisterValidator)) {
            $this->logRegisterValidator = new LogRegisterValidator();
        }
    }

    public function register()
    {
        $token = $this->logRegisterValidator->checkToken();
        $errors = $this->logRegisterValidator->csrfInput('validateRegister');

        if (!$errors) {
            $errors = [];
        }

        if (Session::exists('user')) {
            $this->redirect('home/index');
        }

        $response = $this->renderResponse(
            'log/register.html.twig',
            [
                'token' => $token,
                'error' => $errors
            ]
        );
        return $response;
    }

    public function login()
    {
        $token = $this->logRegisterValidator->checkToken();
        $error = $this->logRegisterValidator->csrfInput('validateLogin');

        if (Session::exists('registersuccess')) {
            $message = Session::flash('registersuccess');
        } else {
            $message = '';
        }

        if (Session::exists('user')) {
            $this->redirect('home/index');
        }

        $response = $this->renderResponse(
            'log/log.html.twig',
            [
                'token' => $token,
                'error' => $error,
                'message' => $message
            ]
        );

        return $response;
    }


    public function admin()
    {
        $token = $this->logRegisterValidator->checkToken();
        $error = $this->logRegisterValidator->csrfInput('validateLoginAdmin');

        if (Session::exists('adminrequired')) {
            $message = Session::flash('adminrequired');
        } else {
            $message = '';
        }

        $response = $this->renderResponse(
            'log/logAdmin.html.twig',
            [
                'token' => $token,
                'error' => $error,
                'message' => $message
            ]
        );
        return $response;
    }

    public function logout($id = '')
    {
        $this->login->logout($id);
        $this->redirect('home/index');
    }
}
