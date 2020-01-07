<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;
use App\Helper\Ajax\PostAjaxRequest;
use App\Helper\Ajax\CommentAjaxRequest;
use App\Helper\Ajax\UserAjaxRequest;
use App\Helper\ValidationForm\Check\AjaxValidator;

/**
 * Ajax controller
 */
class Ajax extends Controller
{
    protected $commentAjaxRequest;
    protected $userAjaxRequest;
    protected $postAjaxRequest;

    protected $ajaxValidator;

    public function __construct()
    {
        $factory = App::getInstance();
        $this->postAjaxRequest = $factory->getAjaxRequest('post');
        $this->commentAjaxRequest = $factory->getAjaxRequest('comment');
        $this->userAjaxRequest = $factory->getAjaxRequest('user');
        $this->ajaxValidator = new AjaxValidator();
    }

    /**
     * admin/show
     * approve an article
     */
    public function approvearticle()
    {
        if (isset($_POST['postid'])) {
            $postId = $_POST['postid'];
            $response = $this->postAjaxRequest->updatePostToValid($postId);
        }
    }

    public function createcomment()
    {
        if (isset($_POST['postid'])) {
            $token = $_POST['token'];
            if ($this->ajaxValidator->csrfInputAjax($token)) {
                $postId = $_POST['postid'];
                $content = $_POST['contentPHP'];
                $userId = $_POST['userid'];
                $response = $this->commentAjaxRequest->createComment($userId, $postId, $content);
            }

            exit($response);
        }
    }

    public function changecommentvalid()
    {
        if (isset($_POST['commentid'])) {
            $commentId = $_POST['commentid'];
            $response = $this->commentAjaxRequest->changeCommentValid($commentId);

            exit($response);
        }
    }

    public function deletepost()
    {
        if (isset($_POST['postid'])) {
            $postId = $_POST['postid'];
            $response = $this->postAjaxRequest->deletePost($postId);
        }
    }

    public function deletecomment()
    {
        if (isset($_POST['commentid'])) {
            $commentId = $_POST['commentid'];
            $response = $this->commentAjaxRequest->deleteComment($commentId);
        }
    }

    public function approve()
    {
        if (isset($_POST['postid'])) {
            $postId = $_POST['postid'];
            $response = $this->postAjaxRequest->updatePostToValid($postId);
        }
    }

    public function updaterole()
    {
        if (isset($_POST['userid'])) {
            $token = $_POST['token'];
            if ($this->ajaxValidator->csrfInputAjax($token)) {
                $userId = $_POST['userid'];
                $response = $this->userAjaxRequest->verifyUserRole($userId);
            }
        }
    }

    public function deleteuser()
    {
        if (isset($_POST['userid'])) {
            $userId = $_POST['userid'];
            $response = $this->userAjaxRequest->verifyDeleteUser($userId);
        }
    }
}
