<?php

namespace App\Core;

use App\Controllers\Traits\CoreTrait;
use App\Helper\ValidationForm\Session;

class Controller
{
    use CoreTrait;

    public function renderResponse(string $template, array $params = [])
    {
        return $this->getTwig()->render($template, $params);
    }

    // url complète
    public function forbidden()
    {
        header('HTTP/1.0 403 forbidden');

        $this->redirect('home/forbidden');
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
        if (!Session::exists('role')) {
            $this->notFound();
        } elseif (Session::get('role') != 'admin') {
            $this->forbidden();
        }
    }

    /**
     * user interface accessibility (admin can also be an user)
     */
    public function userOnly()
    {
        if (!Session::exists('role')) {
            $this->notFound();
        } elseif (Session::get('role') === 'user' || Session::get('role') === 'admin') {
            return;
        } else {
            $this->notFound();
        }
    }
}
