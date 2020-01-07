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

     /*
     * HomePage Default
     */
    public function download()
    {
        if (isset($_REQUEST["file"])) {
            // Get parameters
            $file = urldecode($_REQUEST["file"]); // Decode URL-encoded string
            $filepath = "files/" . $file;

            // Process download
            if (file_exists($filepath)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath);
            exit;
            }
        }
    }
}
