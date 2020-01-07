<?php

namespace App\Helper\ValidationForm\Check;

use App\Core\App;
use App\Application\Config;
use App\Helper\ValidationForm\Input;
use App\Helper\ValidationForm\Session;
use App\Helper\ValidationForm\Hash;
use App\Helper\ValidationForm\Check\Validation;
use App\Helper\ValidationForm\Check\Validator;
use App\Helper\ValidationForm\Login\LoginUser;
use App\Repository\UserRepository;
use App\Helper\ValidationForm\Login\Auth\DBAuthLogin;

/**
 * Form Login/register Validation
 */
class LogRegisterValidator extends Validator
{
    protected $loginUser;
    protected $userRepository;

    protected $loginAdmin;

    public function __construct()
    {
        $factoryRepository = App::getInstance();
        $this->userRepository = $factoryRepository->getRepository('user');
        $this->loginUser = new LoginUser();

        $this->loginAdmin = new DBAuthLogin();
    }

    /**
     * Validation Login User
     * @return array errors, else success redirect to profil/index
     */
    public function validateLogin()
    {
        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true
            ),
            'password' => array(
                'required' => true
            )
        ));

        if ($validate->getPass()) {
            $remember = Input::get('remember') === 'on' ? true : false;

            $login = $this->loginUser->login($remember, Input::get('username'), Input::get('password'));
            $this->loginUser->setIsLoggedIn();

            if ($login) {
                Session::flash('success', 'You Logged-in successfully!');
                Session::delete(Config::get('session/token_name'));


                $this->redirect('profil/index');
            } else {
                 return 'Sorry, logging has failed.';
            }
        } else {
            return $validation->errors();
        }
    }

    /**
     * Validation Login Admin
     * @return array errors, else redirect to admin/dashboard
     */
    public function validateLoginAdmin()
    {
        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true
            ),
            'password' => array(
                'required' => true
            )
        ));

        if ($validate->getPass()) {
            $remember = Input::get('remember') === 'on' ? true : false;

            $login = $this->loginAdmin->loginAdmin($remember, Input::get('username'), Input::get('password'));
            // $this->log->setIsLoggedIn();

            if ($login) {
                Session::flash('LogAdminSuccess', 'You Logged-in successfully!');
                Session::delete(Config::get('session/token_name'));

                // $this->redirect('admin/dashboard');
                $this->redirect('admin/dashboard');
            } else {
                return 'Sorry, logging has failed.';
            }
        } else {
            return $validation->errors();
        }
    }

    /**
     * Validation Register User/Admin
     * @return array errors, else redirect to logregister/login
     */
    public function validateRegister()
    {
        $validate = new Validation();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ),
            'email' => array(
                'required' => true,
                'min' => 9,
                'max' => 30,
                'unique' => 'users',
                'emailformat' => true
            ),
            'password' => array(
                'required' => true,
                'min' => 6
            ),
            'password2' => array(
                'required' => true,
                'matches' => 'password'
            )
        ));

        if ($validate->getPass()) {
            $salt = Hash::salt(32);

            try {
                $this->userRepository->insert(array(
                    'username' => Input::get('username'),
                    'email' => Input::get('email'),
                    'salt' => $salt,
                    'password' => Hash::make(Input::get('password'), $salt),
                    'first_name' => '',
                    'last_name' => '',
                    'joined' => date('Y-m-d H:i:s'),
                    'role' => 'user'
                ));

                Session::flash('registersuccess', 'You registered successfully!');
                Session::delete(Config::get('session/token_name'));

                $this->redirect('logregister/login');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            return $validation->errors();
        }
    }
}
