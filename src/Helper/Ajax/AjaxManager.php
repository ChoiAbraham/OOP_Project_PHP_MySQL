<?php

namespace App\Helper\Ajax;

use App\Core\App;
use App\Helper\Factory\AjaxRequestFactory;

/**
 * uses AjaxRequest instances
 */
class AjaxManager extends AjaxRequestFactory
{
    public function __construct($methodToCall, App $app)
    {
        parent::__construct($app);
        $this->$methodToCall();
    }

    public function createComment()
    {
        if (isset($_POST['postid'])) {
            $postId = $_POST['postid'];
            $content = $_POST['contentPHP'];
            $userId = $_POST['userid'];
            $response = $this->commentAjaxRequest->createComment($userId, $postId, $content);

            exit($response);
        }
    }

    public function changeCommentValid()
    {
        if (isset($_POST['commentid'])) {
            $commentId = $_POST['commentid'];
            $response = $this->commentAjaxRequest->changeCommentValid($commentId);

            exit($response);
        }
    }

    public function deletePost()
    {
        if (isset($_POST['postid'])) {
            $postId = $_POST['postid'];
            $response = $this->postAjaxRequest->deletePost($postId);
        }
    }

    public function deleteComment()
    {
        if (isset($_POST['commentid'])) {
            $commentId = $_POST['commentid'];
            $response = $this->commentAjaxRequest->deleteComment($commentId);
        }
    }

    public function approveArticle()
    {
        if (isset($_POST['postid'])) {
            $postId = $_POST['postid'];
            $response = $this->postAjaxRequest->updatePostToValid($postId);
        }
    }

    public function updateRole()
    {
        if (isset($_POST['userid'])) {
            $userId = $_POST['userid'];
            $response = $this->userAjaxRequest->verifyUserRole($userId);
        }
    }

    public function deleteUser()
    {
        if (isset($_POST['userid'])) {
            $userId = $_POST['userid'];
            $response = $this->userAjaxRequest->verifyDeleteUser($userId);
        }
    }

    public static function getInstance($methodToCall, App $app)
    {
        $singleAjax;

        if (!isset($singleAjax)) {
            $singleAjax = new AjaxManager($methodToCall, $app);
        }

        return $singleAjax;
    }
}
