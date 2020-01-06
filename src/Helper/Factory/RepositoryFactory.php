<?php

namespace App\Helper\Factory;

use App\Core\App;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use App\Repository\PostRepository;
use App\Repository\SessionRepository;
use App\Repository\CountRepository;

    private $postRepository;
    private $commentRepository;
    private $userRepository;
    private $sessionRepository;
    private $countRepository;

    public function __construct()
    {
        $factoryRepository = App::getInstance();
        $this->postRepository = $factoryRepository->getRepository('post');
        $this->commentRepository = $factoryRepository->getRepository('comment');
        $this->userRepository = $factoryRepository->getRepository('user');
        $this->countRepository = $factoryRepository->getRepository('Count');
        $this->sessionRepository = $factoryRepository->getRepository('session');
    }
