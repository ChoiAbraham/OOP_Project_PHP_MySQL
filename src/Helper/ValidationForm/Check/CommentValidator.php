<?php

namespace App\Helper\ValidationForm\Check;

use App\Application\Config;
use App\Helper\ValidationForm\Input;
use App\Helper\ValidationForm\Check\Validator;

class CommentValidator extends Validator
{
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
