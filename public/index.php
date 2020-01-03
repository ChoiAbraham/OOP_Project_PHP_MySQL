<?php

session_start();

require '../vendor/autoload.php';
require_once '../src/Core/init.php';

use App\Core\App;

$app = App::getInstance();

$url = $app->getController();

$response = $app->getMethod($url);

echo $response;
