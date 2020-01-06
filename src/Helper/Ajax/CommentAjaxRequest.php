<?php

namespace App\Helper\Ajax;

use App\Core\App;
use App\Helper\ValidationForm\Check\CommentValidator;
use App\Repository\CommentRepository;
use App\Helper\Ajax\AbstractAjaxRequest;
use App\Core\Singleton;

/**
 * Manages Comments Ajax-Requests
 */
class CommentAjaxRequest extends Singleton
{
    protected $commentRepository;

    public function __construct()
    {
        $factoryRepository = App::getInstance();
        $this->commentRepository = $factoryRepository->getRepository('comment');
    }

    /**
     * form to create a comment through Ajax call
     * @param int $userId, $postId,
     *        string $content
     */
    public function createComment($userId, $postId = '', $content = '')
    {
        $postId = (int)$postId;
        $profil = new CommentValidator();
        $userId = (int)$userId;

        $errors = $profil->inputComment('validateFormComment', $content, $postId, $userId);
    }

    public function deleteComment($commentId)
    {
        $commentId = (int)$commentId;
        $response = $this->commentRepository->deleteCommentById($commentId);
        if ($response) {
            exit('successcommentdelete');
        }
    }

    public function changeCommentValid($commentId)
    {
        $validValue = $this->commentRepository->getCommentValidValue($commentId)->getValid();
        $validValue = (int)$validValue;

        if ($validValue === 1) {
            $response = $this->commentRepository->changeCommentValid(0, $commentId);
            exit('success');
        } elseif ($validValue === 0) {
            $response = $this->commentRepository->changeCommentValid(1, $commentId);
            exit('success');
        }
    }
}
