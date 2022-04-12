<?php

use App\Http\Router;

$router = new Router();

$router->route('/', function () use ($configProvider) {

    $controller = new \App\Controller\IndexController($configProvider);
    $controller->handle();

}, 'POST|GET');

echo $router->route($configProvider->paths->readAndOutputRequestedUrl());