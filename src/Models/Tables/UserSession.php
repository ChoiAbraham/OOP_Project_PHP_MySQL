<?php

namespace App\Models\Tables;

class UserSession
{
    private $id;
    private $hash;
    private $userId;

    /**
     * GETTERS
     */
    public function getId()
    {
        return $this->id;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * SETTERS
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
}
