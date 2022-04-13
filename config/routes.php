<?php

use App\Http\Router;

$router = new Router();

$router->route('/', function () use ($container) {

    $controller = new \App\Controller\IndexController($container);
    $controller->handle();

}, 'POST|GET');

$router->route('/register', function () use ($container) {

    $controller = new \App\Controller\RegisterController($container);
    $controller->handle();

}, 'POST|GET');

$router->route('/login', function () use ($container) {

    $controller = new \App\Controller\LoginController($container);
    $controller->handle();

}, 'POST|GET');

echo $router->route($container->getPaths()->readAndOutputRequestedUrl());