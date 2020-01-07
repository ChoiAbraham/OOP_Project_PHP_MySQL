<?php

namespace App\Helper\ValidationForm\Check;

use App\Core\App;
use App\Repository\PostRepository;
use App\Application\Config;
use App\Helper\ValidationForm\Input;
use App\Helper\ValidationForm\Session;
use App\Helper\ValidationForm\Check\Validation;
use App\Helper\ValidationForm\Check\Validator;
use App\Helper\ValidationForm\Login\AbstractLogin;

/**
 * Post Form Validator
 */
class PostValidator extends Validator
{
    protected $postRepository;
    private $abstractLogin;

    public function __construct()
    {
        $factoryRepository = App::getInstance();
        $this->postRepository = $factoryRepository->getRepository('post');
        $this->abstractLogin = new AbstractLogin();
    }

    /**
     * Validate Form for posting a Post
     * @param int $id [postId]
     * @return array [errors]
     */
    public function validateFormPost($id)
    {
        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'title_post' => array(
                'required' => true
            ),
            'author_post' => array(
                'required' => true
            ),
            'standfirst_post' => array(
                'required' => false
            ),
            'content_post' => array(
                'required' => true
            )
        ));

        if ($validate->getPass()) {
            $jour = date("Y-m-d H:i:s");

            $post = $this->postRepository;
            $post->insertPost(Input::get('title_post'), Input::get('author_post'), Input::get('standfirst_post'), Input::get('content_post'), $jour, $id);

            Session::flash('PostSuccess', 'Your Post is being reviewed and will be confirmed by admin');
            $this->redirect('postlist');
        } else {
            foreach ($validation->errors() as $error) {
                $errors[] = $error;
            }
            return $errors;
        }
    }

    /**
     * Validate Form for updating a Post / User Interface
     * @param int $id [postId]
     * @return array [errors]
     */
    public function validateUpdateFormPostUser($id)
    {
        if ($this->validationUpdate()) {
            $this->updatePost($id);

            Session::flash('updateSuccess', 'Your Post has been successfully updated');
            $iduser = $_SESSION['user'];

            $this->redirect('postlist/mypost/' . $iduser);
        } else {
            foreach ($validation->errors() as $error) {
                $errors[] = $error;
            }
            return $errors;
        }
    }

    /**
     * Validate Form for updating a Post / admin interface
     * @param int $id [postId]
     * @return array [errors]
     */
    public function validateUpdateFormPostAdmin($id)
    {
        if ($this->validationUpdate()) {
            if ($this->updatePost($id)) {
                Session::flash('updateSuccess', 'Your Post has been successfully updated');
                $iduser = $_SESSION['user'];
                $this->redirect('admin/show/' . $id);
            }
        } else {
            foreach ($validation->errors() as $error) {
                $errors[] = $error;
            }
            return $errors;
        }
    }

    private function validationUpdate()
    {
        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'title_post' => array(
                'required' => true
            ),
            'standfirst_post' => array(
                'required' => false
            ),
            'content_post' => array(
                'required' => true
            )
        ));

        return $validate->getPass();
    }

    private function updatePost($id)
    {
        $jour = date("Y-m-d H:i:s");

        $post = $this->postRepository;
        $result = $post->updatePostById($id, array(
            'title' => Input::get('title_post'),
            'author' => Input::get('author_post'),
            'standfirst' => Input::get('standfirst_post'),
            'content' => Input::get('content_post'),
            'lastdate' => $jour
        ));
        return $result;
    }
}
