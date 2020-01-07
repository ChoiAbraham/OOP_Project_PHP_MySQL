<?php

namespace App\controllers;

use App\Core\App;
use App\core\Controller;
use App\Helper\ValidationForm\Input;
use App\Helper\ValidationForm\Session;
use App\Helper\ValidationForm\Hash;
use App\Helper\ValidationForm\Check\ProfilValidator;
use App\Repository\UserRepository;

/**
 * Returns profil pages (profil page, update information page, password reset page)
 */
class Profil extends Controller
{
    protected $user;

    private $profilValidator;

    protected $userRepository;

    public function __construct()
    {
        $factoryRepository = App::getInstance();
        $this->userRepository = $factoryRepository->getRepository('user');
        $this->profilValidator = new ProfilValidator();
    }

    public function index()
    {
        $this->userOnly();

        if (Session::exists('updateSuccess')) {
            $message = Session::get('updateSuccess');
            Session::delete('updateSuccess');
        } else {
            $message = '';
        }

        //login success
        if (Session::exists('success')) {
            $messageregister = Session::flash('success');
        } else {
            $messageregister = '';
        }

        $response = $this->renderResponse(
            'log/profil.html.twig',
            [
                'message' => $message,
                'messageregister' => $messageregister
            ]
        );
        return $response;
    }

    public function update($id = '')
    {
        $this->userOnly();

        $token = $this->profilValidator->checkToken();
        $error = $this->profilValidator->csrfInput('validateUpdate', $id);

        $response = $this->renderResponse(
            'log/update.html.twig',
            [
                'token' => $token,
                'error' => $error
            ]
        );
        return $response;
    }

    /**
     * change password
     */
    public function change($id = '')
    {
        $this->userOnly();

        $token = $this->profilValidator->checkToken();
        $errors = $this->profilValidator->csrfInput('validatePassword', $id);

        if (Session::exists('updateSuccess')) {
            $this->redirect('profil');
        }

        $response = $this->renderResponse(
            'log/password.html.twig',
            [
                'token' => $token,
                'errors' => $errors
            ]
        );
        return $response;
    }

    /**
     * resetpassword : Email Form page to send the link
     * @return [type] [description]
     */
    public function reset()
    {
        $token = $this->profilValidator->checkToken();
        $errors = $this->profilValidator->csrfInput('sendEmailForResetPassword');
        $request = Input::get('email');

        if (!$errors) {
            $errors = [];
        }

        $response = $this->renderResponse(
            'log/reset.html.twig',
            [
                'token' => $token,
                'error' => $errors,
                'request' => $request
            ]
        );
        return $response;
    }

    /**
     * page to reset the password
     * @return [type] [description]
     */
    public function newpass($id)
    {
        /*
        if (Session::exists('updateSuccess')) {
            $this->redirect('home/index');
        }
         */
        $identifier = $_GET['identifier'];
        if (!$id || !$identifier) {
            $this->redirect('home/error404');
        }

        $user = $this->userRepository->findById($id);
        $userid = $user->getId();

        $realHash = $user->getHash();
        $hashToCheck = Hash::hash($identifier);
        $res = Hash::hashCheck($hashToCheck, $realHash);

        if (!$realHash || !$res) {
            $this->redirect('home/error404');
        }

        $token = $this->profilValidator->checkToken();
        $errors = $this->profilValidator->csrfInput('validatePassword', $id);

        $response = $this->renderResponse(
            'log/resetpassword.html.twig',
            [
                'userid' => $userid,
                'token' => $token,
                'error' => $errors,
                'link' => $identifier
            ]
        );
        return $response;
    }
}
