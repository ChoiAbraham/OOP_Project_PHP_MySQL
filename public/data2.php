<?php

// Ajax-call through scripts

require '../vendor/autoload.php';

use App\Core\App;
use App\Helper\Ajax\AjaxManager;

$methodToCall = $_POST['ajaxmethod'];
$app = App::getInstance();

AjaxManager::getInstance($methodToCall, $app);
