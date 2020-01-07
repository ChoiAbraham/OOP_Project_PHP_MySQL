<?php

session_start();

require '../vendor/autoload.php';
require_once '../src/Core/init.php';

use App\Core\App;
use App\Core\Controller;

$app = App::getInstance();

//Test Singleton Pattern
/*

$l1 = App::getInstance();
$l2 = App::getInstance();
if ($l1 === $l2) {
    echo 'single instance';
    exit();
} else {
    echo '2 different instance';
    exit();
}

 */

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

