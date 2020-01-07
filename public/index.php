<?php

session_start();

require '../vendor/autoload.php';
require_once '../src/Core/init.php';

use App\Core\App;
use App\Core\Controller;

set_error_handler(function($errno, $errstr, $errfile, $errline ){
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});

$app = App::getInstance();
$controller = new Controller();

try {
    $url = $app->getController();
    $response = $app->getMethod($url);
    echo $response;
} catch (AdminErrorException $e) {
    $controller->notFoundAdmin();
} catch (Exception $e) {
    $controller->notFound();
}
