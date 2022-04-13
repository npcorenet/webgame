<?php

$container =
    [
        'database_host' => 'db',
        'database_name' => 'db',
        'database_user' => 'db',
        'database_pass' => 'db'
    ];

$container['base_dir'] = __DIR__.'/..';
$container['config_dir'] = __DIR__.'/';
$container['template_dir'] = __DIR__.'/../template';

$container[PDO::class] = function () use ($container) {
    return new PDO('mysql:host=' . $container['database_host'] . ';dbname' . $container['database_name'], $container['database_user'], $container['database_pass']);
};

$container[\Envms\FluentPDO\Query::class] = function () use ($container) {
    return new \Envms\FluentPDO\Query($container[PDO::class]());
};

$container[\Twig\Loader\FilesystemLoader::class] = function () use ($container) {
    return new \Twig\Loader\FilesystemLoader($container['template_dir']);
};

$container[\Twig\Environment::class] = function () use ($container) {
    return new \Twig\Environment(new $container[\Twig\Loader\FilesystemLoader::class]());
};

$container[\App\Http\Paths::class] = function () use ($container) {
    return new \App\Http\Paths();
};

$container[\App\Util\MessageManager::class] = function () use ($container) {
    return new \App\Util\MessageManager();
};

$container[\App\Table\AccountTable::class] = function () use ($container) {
    return new \App\Table\AccountTable(new $container[\Envms\FluentPDO\Query::class]);
};

$container[\App\Util\LoginUtil::class] = function () use ($container) {
    return new \App\Util\LoginUtil(new $container[\Envms\FluentPDO\Query::class], new $container[\App\Table\AccountTable::class]);
};

return $container;