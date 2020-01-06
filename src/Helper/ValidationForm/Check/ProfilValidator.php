<?php

namespace App\Helper\ValidationForm\Check;

use App\Core\App;
use App\Repository\UserRepository;
use App\Application\Config;
use App\Helper\ValidationForm\Input;
use App\Helper\ValidationForm\Session;
use App\Helper\ValidationForm\Hash;
use App\Helper\ValidationForm\Check\Validation;
use App\Helper\ValidationForm\Check\Validator;
use App\Helper\Mailer\Mailer;

/**
 * Validate Profil Info
 */
class ProfilValidator extends Validator
{
    protected $userRepository;

    public function __construct()
    {
        $factoryRepository = App::getInstance();
        $this->userRepository = $factoryRepository->getRepository('user');
    }

    /**
     * Check validation Form Profil Update
     * if success, update profil info
     * @param  [int] $id [userId]
     * @return [array] errors
     */
    public function validateUpdate($id)
    {
        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'firstname' => array(
                'required' => false
            ),
            'lastname' => array(
                'required' => false
            ),
            'email' => array(
                'required' => false
            )
        ));

        if ($validate->getPass()) {
            $user = $this->userRepository;
            $user->update(Input::get('firstname'), Input::get('lastname'), Input::get('email'), $id);

            Session::put('updateSuccess', 'Your details have been updated');
            Session::delete(Config::get('session/token_name'));

            $this->redirect('profil');
        } else {
            return $validation->errors();
        }
    }

    /**
     * Check validation Form Change Password
     * if success, change password
     * @param  [int] $id [userId]
     * @return [array] errors
     */
    public function validatePassword($userid)
    {
        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'password_current' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new_again' => array(
                'required' => true,
                'min' => 6,
                'matches' => 'password_new'
            )
        ));

        if ($validation->getPass()) {
            $user = $this->userRepository;
            $data = $user->findById($userid);

            if (Hash::make(Input::get('password_current'), $data->getSalt()) !== $data->getPassword()) {
                $validate->addError('Your current password is wrong.');
            } else {
                $salt = Hash::salt(32);
                $password = Hash::make(Input::get('password_new'), $salt);

                $user->updatePassword($password, $salt, $data->getId());

                if ($data->getHash()) {
                    $user->deleteHash(null, $data->getId());
                };

                Session::flash('updateSuccess', 'Your password have been updated');
                Session::delete(Config::get('session/token_name'));

                if ($_GET['identifier']) {
                    $this->redirect('home/index');
                }
                $this->redirect('profil');
            }
        } else {
            return $validation->errors();
        }
    }

    /**
     * Check validation Form email to send reset password by email
     * if success, send Email
     * @param  [int] $id [userId]
     * @return [array] errors
     */
    public function sendEmailForResetPassword()
    {
        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'email' => array(
                'required' => true,
                'min' => 9,
                'max' => 30,
                'emailformat' => true
            )
        ));

        if ($validation->getPass()) {
            $userRepository = $this->userRepository;

            $user = $userRepository->getEmail($_POST['email']);
            if (!$user) {
                $validation->addError($item . ' is not in the database. Wrong Email');
                return $validation->errors();
            } else {
                $identifier = Hash::generateRandomString(60);
                $hash = Hash::hash($identifier);
                $id = $user->getId();
                $userRepository->insertHash($hash, $id);

                //Send Email
                $mail = new Mailer();
                $email = $user->getEmail();

                $res = $mail->send(
                    'mail/resetpassword',
                    ['user' => $user, 'link' => $identifier],
                    $callback = function ($message) use ($email) {
                        $message->setFrom('choi.abri@gmail.com', 'Reset Password Recovery');
                        //addAddress
                        $message->to($email);
                        $message->subject('Reset Your Password Email');
                        $message->replyTo('choi.abri@gmail.com', '');
                    }
                );
                $success[] = $res;
                return $success;
            }
        } else {
            return $validation->errors();
        }
    }
}
