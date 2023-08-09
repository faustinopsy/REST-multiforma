<?php

require 'router.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router = new Router($requestMethod, $uri);
$router->run();
