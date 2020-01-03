<?php

namespace App\Models\Tables;

class User
{
    private $id;
    private $username;
    private $email;
    private $salt;
    private $password;
    private $firstname;
    private $lastname;
    private $joined;
    private $role;
    private $hash;

    /**
     * GETTERS
     */
    public function getSalt()
    {
        return $this->salt;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getFirstName()
    {
        return $this->firstname;
    }

    public function getLastName()
    {
        return $this->lastname;
    }

    public function getJoined()
    {
        return $this->joined;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getHash()
    {
        return $this->hash;
    }

    /**
     * SETTERS
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setFirstName($firstname)
    {
        $this->firstname = $firstname;
    }

    public function setLastName($lastname)
    {
        $this->lastname = $lastname;
    }

    public function setJoined($joined)
    {
        $this->joined = $joined;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }
}
