<?php

namespace App\controllers;

use App\core\Controller;
use App\Helper\ValidationForm\Session;

/**
 * HomePage
 */
class Home extends Controller
{
    public function error404()
    {
        if (Session::exists('adminrequired')) {
            $message = Session::flash('adminrequired');
        } else {
            $message = '';
        }

        $response = $this->renderResponse(
            'home/404.html.twig',
            [
                'message' => $message
            ]
        );
        return $response;
    }

    /*
     * HomePage Default
     */
    public function index()
    {
        if (Session::exists('contactresponse')) {
            $message = Session::flash('contactresponse');
        } else {
            $message = '';
        }

        if (!empty($_POST)) {
            include '../src/Helper/contact.php';
            $this->redirect("home/index#contact");
        }

        $pdf = 'mycv.pdf';
        $file = urlencode($pdf);
        $response = $this->renderResponse(
            'home/home.html.twig',
            [
                'pdf' => $file,
                'result' => $message
            ]
        );
        return $response;
    }
}
