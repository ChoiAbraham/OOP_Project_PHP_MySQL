<?php

namespace App\Repository;

use App\Models\Tables\Post;
use PDO;

/**
 * en charge de traiter les interactions avec la base de données concernant les posts
 */
class PostRepository extends AbstractRepository
{
    protected $url;
    protected $extrait;

    private $error = false;

    /**
     * list Posts by number of comments that are not valid
     */
    public function listPostsByCommentsNotValid()
    {
        $stmt = 'SELECT posts.id, posts.title, posts.standfirst, posts.content, posts.lastdate, posts.userId, posts.valid, posts.author, COUNT(comments.valid) AS numberCommentsNotValid FROM posts INNER JOIN comments ON posts.id = comments.postId INNER JOIN users ON posts.userId = users.id WHERE comments.valid = 0 AND posts.valid = 1 GROUP BY posts.id';
        $req = $this->db->prepare($stmt);
        if ($req->execute()) {
            $results = $req->fetchAll(PDO::FETCH_CLASS, Post::class);
            return $results;
        }

        return false;
    }

    /**
     * Pagination
     * list Posts by number of comments that are not valid (page number).
     */
    public function listPostsByCommentsNotValidByLimit($limit, $offset)
    {
        $stmt = 'SELECT posts.id, posts.title, posts.standfirst, posts.content, posts.lastdate, posts.userId, posts.valid, posts.author, COUNT(comments.valid) AS numberCommentsNotValid FROM posts INNER JOIN comments ON posts.id = comments.postId INNER JOIN users ON posts.userId = users.id WHERE comments.valid = 0 AND posts.valid = 1 GROUP BY posts.id';
        $req = $this->db->prepare($stmt);
        $req->bindParam(1, $limit, PDO::PARAM_INT);
        $req->bindParam(2, $offset, PDO::PARAM_INT);
        if ($req->execute()) {
            $results = $req->fetchAll(PDO::FETCH_CLASS, Post::class);
            return $results;
        }

        return false;
    }

    public function posts()
    {
        $stmt = 'SELECT * FROM posts WHERE posts.valid = 1';
        $req = $this->db->prepare($stmt);
        if ($req->execute()) {
            $results = $req->fetchAll(PDO::FETCH_CLASS, Post::class);
            return $results;
        } else {
            return false;
        }
    }

    public function postsByLimit($limit, $offset)
    {
        $stmt = 'SELECT * FROM posts WHERE posts.valid = 1 LIMIT ? OFFSET ?';
        $req = $this->db->prepare($stmt);
        $req->bindParam(1, $limit, PDO::PARAM_INT);
        $req->bindParam(2, $offset, PDO::PARAM_INT);
        if ($req->execute()) {
            $results = $req->fetchAll(PDO::FETCH_CLASS, Post::class);
            return $results;
        }

        return false;
    }

    public function listPosts()
    {
        $stmt = 'SELECT posts.id, posts.title, posts.lastdate, users.username, posts.valid FROM posts INNER JOIN users ON posts.userId = users.id';
        $req = $this->db->prepare($stmt);

        if ($req->execute()) {
            $results = $req->fetchAll(PDO::FETCH_CLASS, Post::class);
            return $results;
        } else {
            return false;
        }
    }

    public function listPostsByLimit($limit, $offset)
    {
        $stmt = 'SELECT posts.id, posts.title, posts.lastdate, users.username, posts.valid FROM posts INNER JOIN users ON posts.userId = users.id LIMIT ? OFFSET ?';
        $req = $this->db->prepare($stmt);
        $req->bindParam(1, $limit, PDO::PARAM_INT);
        $req->bindParam(2, $offset, PDO::PARAM_INT);
        if ($req->execute()) {
            $results = $req->fetchAll(PDO::FETCH_CLASS, Post::class);
            return $results;
        } else {
            return false;
        }
    }

    public function listPostsByValidByLimit($limit, $offset)
    {
        $stmt = 'SELECT posts.id, posts.title, posts.lastdate, users.username, posts.valid FROM posts INNER JOIN users ON posts.userId = users.id ORDER BY posts.valid LIMIT ? OFFSET ?';
        $req = $this->db->prepare($stmt);
        $req->bindParam(1, $limit, PDO::PARAM_INT);
        $req->bindParam(2, $offset, PDO::PARAM_INT);
        if ($req->execute()) {
            $results = $req->fetchAll(PDO::FETCH_CLASS, Post::class);
            return $results;
        } else {
            return false;
        }
    }

    public function listPostsByUsernameByLimit($limit, $offset)
    {
        $stmt = 'SELECT posts.id, posts.title, posts.lastdate, users.username, posts.valid FROM posts INNER JOIN users ON posts.userId = users.id; ORDER BY users.username LIMIT ? OFFSET ?';
        $req = $this->db->prepare($stmt);
        $req->bindParam(1, $limit, PDO::PARAM_INT);
        $req->bindParam(2, $offset, PDO::PARAM_INT);
        if ($req->execute()) {
            $results = $req->fetchAll(PDO::FETCH_CLASS, Post::class);
            return $results;
        } else {
            return false;
        }
    }

    public function findById($id)
    {
        $stmt = 'SELECT * FROM posts WHERE id = :id';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':id', $id);
        if ($req->execute()) {
            $req->setFetchMode(PDO::FETCH_CLASS, Post::class);
            $result = $req->fetch();

            return $result;
        }

        return false;
    }

    public function findByUserId($userid)
    {
        $stmt = 'SELECT * FROM posts WHERE userId = :userid';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':userid', $userid);
        if ($req->execute()) {
            $results = $req->fetchAll(PDO::FETCH_CLASS, Post::class);
            return $results;
        } else {
            return false;
        }
    }

    public function insertPost($title, $author, $standfirst, $content, $date, $userId)
    {
        $stmt = 'INSERT INTO posts (title, author, standfirst, content, lastdate, userId) VALUES (:title, :author, :standfirst, :content, :lastdate, :userid)';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':title', $title, PDO::PARAM_STR);
        $req->bindParam(':author', $author, PDO::PARAM_STR);
        $req->bindParam(':standfirst', $standfirst, PDO::PARAM_STR);
        $req->bindParam(':content', $content, PDO::PARAM_STR);
        $req->bindParam(':lastdate', $date, PDO::PARAM_STR);
        $req->bindParam(':userid', $userId, PDO::PARAM_INT);
        if ($req->execute()) {
            return true;
        }

        return false;
    }

    public function deletePostByUserId($userId)
    {
        $stmt = 'DELETE FROM posts WHERE userId = :userid';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':userid', $userId, PDO::PARAM_INT);
        if ($req->execute()) {
            return true;
        }

        return false;
    }


    public function deletePostById($id)
    {
        $stmt = 'DELETE FROM posts WHERE id = :id';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        if ($req->execute()) {
            return true;
        }

        return false;
    }

    public function updatePostById($postId, $fields)
    {
        $set = '';
        $x = 1;

        foreach ($fields as $name => $value) {
            if (array_key_exists($name, $fields)) {
                $set .= ' ' . $name . ' = :' . $name;
            }

            if ($x < count($fields)) {
                $set .= ',';
            }
            $x++;
        }

        $stmt = 'UPDATE posts SET' . $set . ' WHERE id = :id';
        $fields['id'] = $postId;

        $req = $this->db->prepare($stmt);

        $fieldsBind = [];

        foreach ($fields as $property => $value) {
            $fieldsBind[':' . $property] = $value;
        }

        if ($req->execute($fieldsBind)) {
            return true;
        }

        return false;
    }
}
