<?php

require_once __DIR__ . '/../vendor/autoload.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE');
header('Cache-Control: no-cache, no-store, must-revalidate');
use App\Router;

$requestMethod = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router = new Router($requestMethod, $uri);
$router->run();
