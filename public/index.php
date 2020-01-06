<?php

session_start();

require '../vendor/autoload.php';
require_once '../src/Core/init.php';

use App\Core\App;
use App\Core\Controller;

$app = App::getInstance();
/*

set_error_handler(function($errno, $errstr, $errfile, $errline ){
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});

 */
// try {
    $url = $app->getController();
    $response = $app->getMethod($url);
    echo $response;
// } catch (Exception $e) {
    // $controller = new Controller($app);
    // $controller->notFound();
// }
