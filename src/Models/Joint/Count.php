<?php

namespace App\Models\Joint;

class Count
{
    private $newUserNumber;
    private $postNumber;
    private $commentNumber;

    /**
     * GETTERS
     */
    public function getNewUserNumber()
    {
        return $this->newUserNumber ;
    }
    public function getPostNumber()
    {
        return $this->postNumber ;
    }

    public function getCommentNumber()
    {
        return $this->commentNumber ;
    }

    /**
     * SETTERS
     */
    public function setNewUserNumber()
    {
        $this->newUserNumber = $newUserNumber;
    }

    public function setPostNumber()
    {
        $this->postNumber = $postNumber;
    }

    public function setCommentNumber()
    {
        $this->commentNumber = $commentNumber;
    }
}
