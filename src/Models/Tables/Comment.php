<?php

namespace App\Models\Tables;

use App\Repository\CommentRepository;

class Comment
{
    private $id;
    private $content;
    private $commentDate;
    private $postId;
    private $userId;
    private $valid;
    private $username;

    /**
     * GETTERS
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCommentDate()
    {
        return $this->commentDate;
    }

    public function getpostId()
    {
        return $this->postId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getValid()
    {
        return $this->valid;
    }

    public function getContent()
    {
        return $this->content;
    }

    /**
     * SETTERS
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCommentDate($commentDate)
    {
        $this->commentDate = $commentDate;
    }

    public function setPostId($postId)
    {
        $this->postId = $postId;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setValid($valid)
    {
        $this->valid = $valid;
    }
}
