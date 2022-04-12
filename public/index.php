<?php

require_once __DIR__.'/../vendor/autoload.php';

$configProvider = new \App\ConfigProvider();

$configProvider->add('base_dir', __DIR__.'/..');
$configProvider->add('template_dir', __DIR__.'/../template');
$configProvider->add('config_dir', __DIR__.'/../config');

require_once $configProvider->get('config_dir') . '/database.php';

$pdo = new PDO('mysql:host='.$databaseConfig['database_host'].';dbname='.$databaseConfig['database_name'],
    $databaseConfig['database_user'], $databaseConfig['database_pass']);

$database = (new \App\Factory\DatabaseFactory())->build($pdo);
unset($databaseConfig);
unset($pdo);

$paths = new \App\Http\Paths();

$twigEnv = new Twig\Loader\FilesystemLoader($configProvider->get('template_dir'));
$twig = new Twig\Environment($twigEnv);

$configProvider->database = $database;
$configProvider->paths = $paths;
$configProvider->twig = $twig;

require_once $configProvider->get('base_dir') . '/routes.php';