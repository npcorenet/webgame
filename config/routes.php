<?php

use App\Http\Router;

$router = new Router();

$router->route('/', function () use ($container) {

    $controller = new \App\Controller\IndexController($container);
    $controller->handle();

}, 'POST|GET');

$router->route('/register', function () use ($container) {

    if($container->getLoginUtil()->getIsLoggedIn())
    {
        header("Location:".$container->getPaths()->readAndOutputRequestedPath().'/');
        return;
    }

    $controller = new \App\Controller\RegisterController($container);
    $controller->handle();

}, 'POST|GET');

$router->route('/login', function () use ($container) {

    if($container->getLoginUtil()->getIsLoggedIn())
    {
        header("Location:".$container->getPaths()->readAndOutputRequestedPath().'/');
        return;
    }

    $controller = new \App\Controller\LoginController($container);
    $controller->handle();

}, 'POST|GET');

$router->route('/inventory', function () use ($container) {

    if(!$container->getLoginUtil()->getIsLoggedIn())
    {
        header("Location:".$container->getPaths()->readAndOutputRequestedPath().'/login');
        return;
    }

    $controller = new \App\Controller\InventoryController($container);
    $controller->handle();

}, 'POST|GET');

$router->route('/areas', function () use ($container) {

    if(!$container->getLoginUtil()->getIsLoggedIn())
    {
        header("Location:".$container->getPaths()->readAndOutputRequestedPath().'/login');
        return;
    }

    $controller = new \App\Controller\AreaListController($container);
    $controller->handle();

}, 'POST|GET');

$router->route('/area/(\d+)(/claim)?', function ($areaId, $claim = '') use ($container) {

    if(!$container->getLoginUtil()->getIsLoggedIn())
    {
        header("Location:".$container->getPaths()->readAndOutputRequestedPath().'/login');
        return;
    }

    $container->areaId = $areaId;
    $container->claim = $claim;

    $controller = new \App\Controller\AreaController($container);
    $controller->handle();

}, 'POST|GET');

$router->route('/logout', function () use ($container) {

    $controller = new \App\Controller\LogoutController($container);
    $controller->handle();

}, 'POST|GET');

$router->route('/admin/items', function () use ($container) {

    if(!$container->getLoginUtil()->getIsLoggedIn() && !$container->getLoginUtil()->validateLogin() < 3) { header("Location:".$container->getPaths()->readAndOutputRequestedPath().'/login'); return; }

    $controller = new \App\AdminController\ItemController($container);
    $controller->handle();

}, 'POST|GET');

echo $router->route($container->getPaths()->readAndOutputRequestedUrl());