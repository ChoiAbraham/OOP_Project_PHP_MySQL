<?php

namespace App\Repository;

use App\Models\Joint\Count;
use App\Models\Tables\User;
use PDO;

class CountRepository extends AbstractRepository
{
    /**
     * Dashboard Admin
     * count number of new users (today)
     *       number of posts not valid
     *       number of new comments not valid
     */
    public function countUserPostComment()
    {
        $stmt = 'SELECT
        (SELECT COUNT(users.id) FROM users WHERE date(`joined`) = current_date) AS newUserNumber,
        (SELECT COUNT(posts.id) FROM `posts` WHERE posts.valid = 0) AS postNumber,
        (SELECT COUNT(comments.id) FROM `comments` WHERE comments.valid = 0) AS commentNumber';
        $req = $this->db->prepare($stmt);
        if ($req->execute()) {
            $results = $req->fetchAll(PDO::FETCH_CLASS, Count::class);
            return $results;
        }

        return false;
    }
}
