<?php

namespace App\Repository;

use App\Models\Tables\Comment;
use App\Models\Tables\User;
use PDO;

class CommentRepository extends AbstractRepository
{
    public function listComments($id)
    {
        $stmt = 'SELECT c.id, c.content, c.commentdate AS commentDate, c.postId, c.valid, u.username FROM comments c JOIN users u ON c.userId = u.id WHERE c.postId = :postid ORDER BY c.commentdate';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':postid', $id);
        if ($req->execute()) {
            $req->setFetchMode(PDO::FETCH_CLASS, Comment::class);
            $result = $req->fetchAll();

            return $result;
        }

        return false;
    }

    /**
     * change comment.valid to 0 or 1
     * @param  int $commentId
     */
    public function changeCommentValid($newValue, $commentId)
    {
        $stmt = 'UPDATE comments SET valid = :newvalue WHERE id = :commentid';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':newvalue', $newValue);
        $req->bindParam(':commentid', $commentId);
        if ($req->execute()) {
            return true;
        }

        return false;
    }

    /**
     * get the value of "Valid" of the table comments
     * @param  int $commentId
     */
    public function getCommentValidValue($commentId)
    {
        $stmt = 'SELECT comments.valid FROM comments WHERE id = :commentid';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':commentid', $commentId);
        if ($req->execute()) {
            $req->setFetchMode(PDO::FETCH_CLASS, Comment::class);
            $result = $req->fetch();

            return $result;
        }

        return false;
    }

    public function findCommentsByUserId($userid)
    {
        $stmt = 'SELECT * FROM comments WHERE user_id = :userid';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':userid', $userid);
        if ($req->execute()) {
            $req->setFetchMode(PDO::FETCH_CLASS, Comment::class);
            $result = $req->fetch();

            return $result;
        }

        return false;
    }

    public function insertComment($content, $date, $postId, $userId)
    {
        $stmt = 'INSERT INTO comments (content, commentdate, postId, userId) VALUES (:content, :commentdate, :postId, :userId)';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':content', $content, PDO::PARAM_STR);
        $req->bindParam(':commentdate', $date, PDO::PARAM_STR);
        $req->bindParam(':postId', $postId, PDO::PARAM_INT);
        $req->bindParam(':userId', $userId, PDO::PARAM_INT);
        if ($req->execute()) {
            return true;
        }

        return false;
    }

    public function deleteCommentsUserId($userId)
    {
        $stmt = 'DELETE FROM comments WHERE userId = :userid';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':userid', $userId, PDO::PARAM_INT);
        if ($req->execute()) {
            return true;
        }

        return false;
    }

    public function deleteCommentsByPostId($postId)
    {
        $stmt = 'DELETE FROM comments WHERE postId = :postId';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':postId', $postId, PDO::PARAM_INT);
        if ($req->execute()) {
            return true;
        }

        return false;
    }

    public function deleteCommentById($commentId)
    {
        $stmt = 'DELETE FROM comments WHERE id = :commentid';
        $req = $this->db->prepare($stmt);
        $req->bindParam(':commentid', $commentId, PDO::PARAM_INT);
        if ($req->execute()) {
            return true;
        }

        return false;
    }
}
