<?php

use App\Controllers\HomeController;
use App\Controllers\MagazineController;
use App\Router;

$router = new Router();

$router->addRoute('GET', '/', HomeController::class, 'index');
$router->addRoute('POST', '/magazine/download', MagazineController::class, 'store');
$router->addRoute('POST', '/magazine', MagazineController::class, 'index');

return $router;
