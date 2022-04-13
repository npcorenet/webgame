<?php
session_start();

require_once __DIR__.'/../vendor/autoload.php';

$container = new \App\Container();

require_once $container->getConfigDir() . '/routes.php';