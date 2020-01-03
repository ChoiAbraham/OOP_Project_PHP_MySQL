<?php

namespace App\Models\Tables;

class Post
{
    private $id;
    private $title;
    private $standfirst;
    private $content;
    private $userId;
    private $lastdate;
    private $url;
    private $key;

    //username
    private $userUsername;

    //Number of new comments
    private $numberCommentsNotValid;

    public function __construct()
    {
        $this->setUrl();
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl()
    {
        $this->url = 'postlist/show/' . $this->id;
    }

    /**
     * GETTERS
     */
    public function getNumberCommentsNotValid()
    {
        return $this->numberCommentsNotValid;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getStandfirst()
    {
        return $this->standfirst;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getLastDate()
    {
        return $this->lastdate;
    }


    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * SETTERS
     */
    public function setNumberOfCommentsNotValid($numberCommentsNotValid)
    {
        $this->numberCommentsNotValid = $numberCommentsNotValid;
    }

    public function setLastDate($lastdate)
    {
        $this->lastdate = $lastdate;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setStandfirst($standfirst)
    {
        $this->standfirst = $standfirst;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setEntry($entry)
    {
        $this->entry = $entry;
    }
}
