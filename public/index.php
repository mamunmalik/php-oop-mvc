<?php
require_once('../app/config/config.php');
require_once(APPROOT . '/controllers/PaymentController.php');

$controller = new PaymentController();

if (isset($_GET['url'])) {
    $url = explode('/', $_GET['url']);
    $controllerName = ucfirst($url[0]) . 'Controller';
    $actionName = $url[1] ?? 'index';
} else {
    $controllerName = 'PaymentController';
    $actionName = 'index';
}

$controller->$actionName();