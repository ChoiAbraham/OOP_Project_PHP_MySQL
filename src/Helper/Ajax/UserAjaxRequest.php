<?php

namespace App\Helper\Ajax;

use App\Repository\UserRepository;
use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use App\Helper\Ajax\AbstractAjaxRequest;

/**
 * Manages User Ajax-Requests
 */
class UserAjaxRequest extends AbstractAjaxRequest
{
    public function verifyUserRole($userId)
    {
        $userId = (int)$userId;
        $roleValue = $this->userRepository->findById($userId)->getRole();

        if ($roleValue === 'admin' && $_POST['rolechoosen'] === 'user') {
            $response = $this->userRepository->updateRole('user', $userId);
            exit('successuser');
        } elseif ($roleValue === 'user' && $_POST['rolechoosen'] === 'admin') {
            $response = $this->userRepository->updateRole('admin', $userId);
            exit('successadmin');
        }
    }

    public function verifyDeleteUser($userId)
    {
        $bool1 = $this->postRepository->deletePostByUserId($userId);
        $bool2 = $this->commentRepository->deleteCommentsUserId($userId);

        if ($bool1 && $bool2) {
            $bool3 = $this->userRepository->deleteUser($userId);
            exit('successdelete');
        }
    }
}
