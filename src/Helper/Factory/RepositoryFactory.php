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
    protected $countRepository;

    private $repositoryFactory;

    public function __construct()
    {
        $this->repositoryFactory = App::getInstance();
        if (!isset($this->postRepository)) {
            $this->postRepository = $this->repositoryFactory->getRepository('post');
        }
        if (!isset($this->commentRepository)) {
            $this->commentRepository = $this->repositoryFactory->getRepository('comment');
        }
        if (!isset($this->userRepository)) {
            $this->userRepository = $this->repositoryFactory->getRepository('user');
        }
        if (!isset($this->countRepository)) {
            $this->countRepository = $this->repositoryFactory->getRepository('Count');
        }
    }
}
