<?php

namespace App\Repository;

use App\Models\Tables\UserSession;
use PDO;

/**
 * en charge de traiter les interactions avec la base de données concernant le Hash Session
 */
class SessionRepository extends AbstractRepository
{
    protected $url;
    protected $extrait;

    public function findByUserId($id)
    {
        $stmt = 'SELECT * FROM users_session WHERE userId = :id';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':id', $id);
        if ($req->execute()) {
            $req->setFetchMode(PDO::FETCH_CLASS, UserSession::class);
            $result = $req->fetch();

            return $result;
        } else {
            return false;
        }
    }

    public function insertHash($hash, $userId)
    {
        $stmt = 'INSERT INTO users_session (hash, userId) VALUES (:hash, :userid)';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':hash', $hash, PDO::PARAM_STR);
        $req->bindParam(':userid', $userId, PDO::PARAM_INT);
        if ($req->execute()) {
            return true;
        }

        return false;
    }

    public function findHash($hash)
    {
        $stmt = 'SELECT * FROM users_session WHERE hash = :hash';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':hash', $hash);
        if ($req->execute()) {
            $req->setFetchMode(PDO::FETCH_CLASS, UserSession::class);
            $result = $req->fetch();
            return $result;
        }

        return false;
    }

    public function deleteHashByUserId($id)
    {
        $stmt = 'DELETE FROM users_session WHERE userId = :id';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        if ($req->execute()) {
            return true;
        }

        return false;
    }
}
