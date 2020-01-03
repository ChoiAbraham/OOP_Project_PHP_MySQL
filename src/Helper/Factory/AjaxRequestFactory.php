<?php

namespace App\Helper\Factory;

use App\Core\App;
use App\Helper\Ajax\PostAjaxRequest;
use App\Helper\Ajax\CommentAjaxRequest;
use App\Helper\Ajax\UserAjaxRequest;

/**
 * Get the instances of all AjaxRequest
 * Factory Pattern is in App
 */
class AjaxRequestFactory
{
    protected $commentAjaxRequest;
    protected $userAjaxRequest;
    protected $postAjaxRequest;
    protected $ajaxRequestFactory;

    public function __construct(App $app)
    {
        $this->ajaxRequestFactory = $app;
        if (!isset($this->postAjaxRequest)) {
            $this->postAjaxRequest = $this->ajaxRequestFactory->getAjaxRequest('post');
        }
        if (!isset($this->commentRepository)) {
            $this->commentAjaxRequest = $this->ajaxRequestFactory->getAjaxRequest('comment');
        }
        if (!isset($this->userRepository)) {
            $this->userAjaxRequest = $this->ajaxRequestFactory->getAjaxRequest('user');
        }
    }
}
