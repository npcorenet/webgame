<?php
session_start();

require_once __DIR__.'/../vendor/autoload.php';

$configProvider = new \App\ConfigProvider();

$configProvider->add('base_dir', __DIR__.'/..');
$configProvider->add('template_dir', __DIR__.'/../template');
$configProvider->add('config_dir', __DIR__.'/../config');

require_once $configProvider->get('config_dir') . '/database.php';

$database = (new \App\Factory\DatabaseFactory())->build(
    new PDO('mysql:host='.$databaseConfig['database_host'].';dbname='.$databaseConfig['database_name'],
    $databaseConfig['database_user'], $databaseConfig['database_pass']));

$paths = new \App\Http\Paths();

$twigEnv = new Twig\Loader\FilesystemLoader($configProvider->get('template_dir'));
$twig = new Twig\Environment($twigEnv);

$messageManager = new \App\Util\MessageManager();

$configProvider->database = $database;
$configProvider->paths = $paths;
$configProvider->twig = $twig;
$configProvider->messageManager = $messageManager;

$configProvider->add('prefix', 'webgame_');

require_once $configProvider->get('config_dir') . '/routes.php';