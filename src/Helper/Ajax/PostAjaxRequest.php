<?php

namespace App\Helper\Ajax;

use App\Core\App;
use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use App\Helper\Ajax\AbstractAjaxRequest;
use App\Core\Singleton;

/**
 * Manages Posts Ajax-Requests
 */
class PostAjaxRequest extends Singleton
{
    protected $postRepository;
    protected $commentRepository;

    public function __construct()
    {
        $factoryRepository = App::getInstance();
        $this->postRepository = $factoryRepository->getRepository('post');
        $this->commentRepository = $factoryRepository->getRepository('comment');
    }

    /**
     * delete post through Ajax call
     * @param string $id userId
     */
    public function deletePost($postId = '')
    {
        $postId = (int)$postId;
        $comment = $this->commentRepository->deleteCommentsByPostId($postId);
        $post = $this->postRepository->deletePostById($postId);

        exit('Your Post Has Been Deleted');
    }

    public function updatePostToValid($postId = '')
    {
        $postId = (int)$postId;

        $post = $this->postRepository->updatePostById($postId, array(
            'valid' => 1
        ));
        exit('Your Post Has Been Approved');
    }
}
