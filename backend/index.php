<?php
require_once '../common/config/db-init.php';

$params = require __DIR__ . '../../common/config/params-local.php';

$requestUri = $_SERVER['REQUEST_URI'];

// Extract the path from the request URI and remove any query parameters
$basePath = parse_url($requestUri, PHP_URL_PATH);
$basePath = rtrim($basePath, '/');

$pathSegments = explode('/', $basePath);

// Set default controller and method
$controller = 'user';
$method = 'index';

// Check if the path has controller and method segments
if (isset($pathSegments[1]) && !empty($pathSegments[1])) {
    $controller = $pathSegments[1];
}

if (isset($pathSegments[2]) && !empty($pathSegments[2])) {
    $method = $pathSegments[2];
}

// Construct the controller class name and method name
$controllerClassName = ucfirst($controller) . 'Controller';
$method = strtolower($method);

// Load the corresponding controller file
$controllerFilePath = __DIR__ . '/controllers/' . $controllerClassName . '.php';

if (file_exists($controllerFilePath)) {
    require_once $controllerFilePath;
    require_once '../common/models/' . ucfirst($controller) . 'Model.php';

    $controllerClassName = 'backend\controllers\\' . $controllerClassName;
    $controllerInstance = new $controllerClassName;

    if (method_exists($controllerInstance, $method)) {
        $controllerInstance->$method();
    } else {
        include 'views/site/error.php';
        exit();
    }
} else {
    include 'views/site/error.php';
    exit();
}