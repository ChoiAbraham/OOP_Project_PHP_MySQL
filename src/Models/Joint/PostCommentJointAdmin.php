<?php

namespace App\Models\Joint;

/**
 * to hydrate values from database from CommentRepository method listCommentsByPostId()
 */
class PostCommentJointAdmin
{
    private $postId;
    private $postTitle;
    private $postStandfirst;
    private $postContent;
    private $postLastdate;
    private $postUserId;
    private $postValid;

    private $userUsername;

    private $commentId;
    private $commentPostId;
    //Number of new comments
    private $validation;

    /**
     * GETTERS
     */
    public function getPostId()
    {
        return $this->postId;
    }

    public function getUserUsername()
    {
        return $this->userUsername;
    }

    public function getPostTitle()
    {
        return $this->postTitle;
    }

    public function getPostStandfirst()
    {
        return $this->postStandfirst;
    }

    public function getPostContent()
    {
        return $this->postContent;
    }

    public function getPostLastdate()
    {
        return $this->postLastdate;
    }

    public function getPostUserId()
    {
        return $this->valid;
    }

    public function getPostValid()
    {
        return $this->postValid;
    }

    public function getValidation()
    {
        return $this->validation;
    }

    public function getCommentPostId()
    {
        return $this->commentPostId;
    }

    public function getCommentId()
    {
        return $this->commentId;
    }

    /**
     * SETTERS
     */
    public function setPostId($postId)
    {
        $this->postId = $postId;
    }

    public function setUserUsername($userUsername)
    {
        $this->userUsername = $userUsername;
    }

    public function setPostTitle($postTitle)
    {
        $this->postTitle = $postTitle;
    }

    public function setPostStandfirst($postStandfirst)
    {
        $this->postStandfirst = $postStandfirst;
    }

    public function setPostContent($postContent)
    {
        $this->postContent = $postContent;
    }

    public function setPostLastdate($postLastdate)
    {
        $this->postLastdate = $postLastdate;
    }

    public function setPostUserId($postUserId)
    {
        $this->postUserId = $postUserId;
    }

    public function setPostValid($postValid)
    {
        $this->postValid = $postValid;
    }

    public function setCommentId($commentId)
    {
        $this->commentId = $commentId;
    }

    public function setCommentPostId($commentPostId)
    {
        $this->commentPostId = $commentPostId;
    }

    public function setValidation($validation)
    {
        $this->validation = $validation;
    }
}
