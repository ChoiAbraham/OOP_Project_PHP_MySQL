<?php

namespace App\Helper\ValidationForm\Check;

use App\Core\App;
use App\Repository\CommentRepository;
use App\Application\Config;
use App\Helper\ValidationForm\Input;
use App\Helper\ValidationForm\Check\Validator;

class CommentValidator extends Validator
{
    protected $commentRepository;

    public function __construct()
    {
        $factoryRepository = App::getInstance();
        $this->commentRepository = $factoryRepository->getRepository('comment');
    }

    public function inputComment($functionName, $content, $postId, $userId = '')
    {
        if (Input::exists()) {
            return static::$functionName($content, $postId, $userId);
        }
    }

    public function validateFormComment($content, $postId, $userId)
    {
        $jour = date("Y-m-d H:i:s");

        $user = $this->commentRepository;
        $user->insertComment($content, $jour, $postId, $userId);

        exit('CommentSuccess');
    }
}
