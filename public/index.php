<?php
session_start();

require_once __DIR__.'/../vendor/autoload.php';

$container = require_once __DIR__ . '/../config/container.php';

require_once $container['config_dir'] . '/routes.php';