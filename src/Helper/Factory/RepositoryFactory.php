<?php

namespace App\Helper\Factory;

use App\Core\App;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use App\Repository\PostRepository;
use App\Repository\CountRepository;

/**
 * Get the instances of all Repository
 * Factory Pattern is in App
 */
class RepositoryFactory
{
    protected $postRepository;
    protected $commentRepository;
    protected $userRepository;
    protected $sessionRepository;
    protected $countRepository;

    protected $repositoryFactory;

    public function __construct()
    {
        $this->repositoryFactory = App::getInstance();
        $this->postRepository = $this->repositoryFactory->getRepository('post');
        $this->commentRepository = $this->repositoryFactory->getRepository('comment');
        $this->userRepository = $this->repositoryFactory->getRepository('user');
        $this->countRepository = $this->repositoryFactory->getRepository('Count');
        $this->sessionRepository = $this->repositoryFactory->getRepository('session');
    }
}
