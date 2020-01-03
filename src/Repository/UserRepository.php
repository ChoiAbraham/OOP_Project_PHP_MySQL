<?php

namespace App\Repository;

use App\Models\Tables\User;
use App\Application\Config;
use App\Helper\ValidationForm\Session;
use PDO;

/**
 * en charge de traiter les interactions avec la base de données concernant les posts
 */
class UserRepository extends AbstractRepository
{
    public function listUsers()
    {
        $stmt = 'SELECT * FROM users';
        $req = $this->db->prepare($stmt);
        if ($req->execute()) {
            $results = $req->fetchAll(PDO::FETCH_CLASS, User::class);
            return $results;
        }

        return false;
    }

    public function listAdmins()
    {
        $stmt = "SELECT * FROM users WHERE role = 'admin'";
        $req = $this->db->prepare($stmt);
        if ($req->execute()) {
            $results = $req->fetchAll(PDO::FETCH_CLASS, User::class);
            return $results;
        }

        return false;
    }

    public function listUsersByLimit($limit, $offset)
    {
        $stmt = 'SELECT * FROM users LIMIT ? OFFSET ?';
        $req = $this->db->prepare($stmt);
        $req->bindParam(1, $limit, PDO::PARAM_INT);
        $req->bindParam(2, $offset, PDO::PARAM_INT);
        if ($req->execute()) {
            $results = $req->fetchAll(PDO::FETCH_CLASS, User::class);
            return $results;
        }

        return false;
    }

    public function listAdminsByLimit($limit, $offset)
    {
        $stmt = "SELECT * FROM users WHERE role='admin' LIMIT ? OFFSET ?";
        $req = $this->db->prepare($stmt);
        $req->bindParam(1, $limit, PDO::PARAM_INT);
        $req->bindParam(2, $offset, PDO::PARAM_INT);
        if ($req->execute()) {
            $results = $req->fetchAll(PDO::FETCH_CLASS, User::class);
            return $results;
        }

        return false;
    }

    public function listUsersByUsername()
    {
        $stmt = 'SELECT * FROM users ORDER BY username';
        $req = $this->db->prepare($stmt);
        if ($req->execute()) {
            $results = $req->fetchAll(PDO::FETCH_CLASS, User::class);
            return $results;
        }

        return false;
    }

    public function listUsersByUsernameByLimit($limit, $offset)
    {
        $stmt = 'SELECT * FROM users ORDER BY username LIMIT ? OFFSET ?';
        $req = $this->db->prepare($stmt);
        $req->bindParam(1, $limit, PDO::PARAM_INT);
        $req->bindParam(2, $offset, PDO::PARAM_INT);
        if ($req->execute()) {
            $results = $req->fetchAll(PDO::FETCH_CLASS, User::class);
            return $results;
        }

        return false;
    }

    public function listAdminsByUsernameByLimit($limit, $offset)
    {
        $stmt = "SELECT * FROM users WHERE role = 'admin' ORDER BY username LIMIT ? OFFSET ?";
        $req = $this->db->prepare($stmt);
        $req->bindParam(1, $limit, PDO::PARAM_INT);
        $req->bindParam(2, $offset, PDO::PARAM_INT);
        if ($req->execute()) {
            $results = $req->fetchAll(PDO::FETCH_CLASS, User::class);
            return $results;
        }

        return false;
    }

    public function findById($id)
    {
        $stmt = 'SELECT * FROM users WHERE id = :id';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':id', $id);
        if ($req->execute()) {
            $req->setFetchMode(PDO::FETCH_CLASS, User::class);
            $result = $req->fetch();
            return $result;
        }

        return false;
    }

    public function findByUsername($username)
    {
        $stmt = 'SELECT * FROM users WHERE username = :username';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':username', $username);
        if ($req->execute()) {
            $req->setFetchMode(PDO::FETCH_CLASS, User::class);
            $result = $req->fetch();
            return $result;
        }

        return false;
    }

    public function getUsername($username)
    {
        $stmt = 'SELECT users.username FROM users WHERE username = :username';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':username', $username);
        if ($req->execute()) {
            $result = $req->fetch();
            return $result;
        }

        return false;
    }

    public function getEmail($email)
    {
        $stmt = 'SELECT users.username, users.email, users.id, users.firstname, users.lastname FROM users WHERE email = :email';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':email', $email);
        if ($req->execute()) {
            $req->setFetchMode(PDO::FETCH_CLASS, User::class);
            $result = $req->fetch();
            return $result;
        }

        return false;
    }

    public function create($fields = array())
    {
        //if(!$this->insert($fields)) {
            //throw new \Exception('There was a problem creating an account');
        //}
        var_dump($fields);
    }

    public function insert($fields)
    {
        $stmt = 'INSERT INTO users (username, email, salt, password, firstname, lastname, joined, role) VALUES (:username, :email, :salt, :password, :first_name, :last_name, :joined, :role)';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':username', $fields['username'], PDO::PARAM_STR);
        $req->bindParam(':email', $fields['email'], PDO::PARAM_STR);
        $req->bindParam(':salt', $fields['salt'], PDO::PARAM_STR);
        $req->bindParam(':password', $fields['password'], PDO::PARAM_STR);
        $req->bindParam(':first_name', $fields['first_name'], PDO::PARAM_STR);
        $req->bindParam(':last_name', $fields['last_name'], PDO::PARAM_STR);
        $req->bindParam(':joined', $fields['joined'], PDO::PARAM_STR);
        $req->bindParam(':role', $fields['role'], PDO::PARAM_STR);

        if ($req->execute()) {
            return true;
        }

        return false;
    }

    public function insertHash($hash, $userId)
    {
        $stmt = 'UPDATE users SET hash = :hash WHERE id=:userid';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':hash', $hash);
        $req->bindParam(':userid', $userId, PDO::PARAM_STR);

        if ($req->execute()) {
            return true;
        }

        return false;
    }

    public function update($firstname = '', $lastname = '', $email = '', $userId)
    {
        $stmt = 'UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email WHERE id=:userid';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $req->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->bindParam(':userid', $userId, PDO::PARAM_STR);

        if ($req->execute()) {
            return true;
        }

        return false;
    }

    public function updateRole($newRole, $userId = '')
    {
        $stmt = 'UPDATE users SET role = :newrole WHERE id=:userid';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':newrole', $newRole, PDO::PARAM_STR);
        $req->bindParam(':userid', $userId, PDO::PARAM_STR);
        if ($req->execute()) {
            return true;
        }

        return false;
    }

    public function updatePassword($password, $salt, $userid)
    {
        $stmt = 'UPDATE users SET salt = :salt, password = :password WHERE id= :userid';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':salt', $salt, PDO::PARAM_STR);
        $req->bindParam(':password', $password, PDO::PARAM_STR);
        $req->bindParam(':userid', $userid, PDO::PARAM_STR);

        if ($req->execute()) {
            return true;
        }

        return false;
    }

    public function deleteUser($userId)
    {
        $stmt = 'DELETE FROM users WHERE id = :userid';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':userid', $userId, PDO::PARAM_INT);
        if ($req->execute()) {
            return true;
        }

        return false;
    }

    public function deleteHash($hash, $userId)
    {
        $stmt = 'UPDATE users SET hash = :hash WHERE id = :userid';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':hash', $hash, PDO::PARAM_INT);
        $req->bindParam(':userid', $userId, PDO::PARAM_INT);
        if ($req->execute()) {
            return true;
        }

        return false;
    }
}
