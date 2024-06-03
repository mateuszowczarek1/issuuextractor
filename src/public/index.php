<?php

require __DIR__ . '/../vendor/autoload.php';

ini_set('memory_limit', '1024M');
set_time_limit(500);


$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

$router = require_once __DIR__ . '/../routes/web.php';

$response = $router->dispatch($requestUri, $requestMethod);

echo $response;
