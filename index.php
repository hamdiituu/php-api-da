<?php

require_once __DIR__ . '/vendor/autoload.php';

use Core\Router;
use Http\Routers\ApiRouter;

$router = new Router();

$router->setPrefix('/api');

ApiRouter::register($router);

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router->dispatch($method, $uri);
