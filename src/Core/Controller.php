<?php

namespace App\Core;

use App\Controllers\Traits\CoreTrait;
use App\Helper\Factory\RepositoryFactory;
use App\Helper\ValidationForm\Session;

class Controller extends RepositoryFactory
{
    use CoreTrait;

    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    public function renderResponse(string $template, array $params = [])
    {
        return $this->getTwig()->render($template, $params);
    }

    // url complète
    public function forbidden()
    {
        header('HTTP/1.0 403 forbidden');
        die('Access interdit');
    }

    public function notFound()
    {
        header('HTTP/1.0 404 Not found');

        $this->redirect('home/error404');
    }

    public function notFoundAdmin()
    {
        header('HTTP/1.0 404 Not found');

        $this->redirect('admin/error404');
    }

    public function redirect($location = null)
    {
        if ($location) {
            $location = '/' . $location;
            header('Location:' . $location);
            exit();
        }
        //header('HTTP/1.1 Moved Permanently', false, 301);
        //header(sprintf('Location : %s', $url));
    }

    /**
     * admin interface accessibility, check if admin
     */
    public function adminOnly()
    {
        if (!Session::exists('auth')) {
            $this->notFound();
        }
    }
}
