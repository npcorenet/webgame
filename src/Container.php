<?php

namespace App;

use App\Http\Paths;
use App\Table\AccountTable;
use App\Util\LoginUtil;
use App\Util\MessageManager;
use Envms\FluentPDO\Query;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Container
{

    private string $dbHost = 'db';
    private string $dbName = 'db';
    private string $dbUser = 'db';
    private string $dbPassword = 'db';

    private string $prefix = 'webgame_';

    private string $baseDir = __DIR__.'/..';
    private string $templateDir = __DIR__.'/../template';
    private string $configDir = __DIR__.'/../config';

    private \PDO $PDO;
    private Query $database;
    private FilesystemLoader $filesystemLoader;
    private Environment $twig;
    private MessageManager $messageManager;
    private Paths $paths;
    private LoginUtil $loginUtil;

    public function __construct()
    {

        $this->PDO = new \PDO('mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName, $this->dbUser, $this->dbPassword);
        $this->database = new Query($this->PDO);

        $this->filesystemLoader = new FilesystemLoader($this->templateDir);
        $this->twig = new Environment($this->filesystemLoader);

        $this->messageManager = new MessageManager();

        $this->paths = new Paths();

        $this->loginUtil = new LoginUtil($this->prefix, $this->twig, new AccountTable($this->database));

    }

    public function getBaseDir(): string
    {
        return $this->baseDir;
    }

    public function getTemplateDir(): string
    {
        return $this->templateDir;
    }

    public function getConfigDir(): string
    {
        return $this->configDir;
    }

    public function getPDO(): \PDO
    {
        return $this->PDO;
    }

    public function getDatabase(): Query
    {
        return $this->database;
    }

    public function getFilesystemLoader(): FilesystemLoader
    {
        return $this->filesystemLoader;
    }

    public function getTwig(): Environment
    {
        return $this->twig;
    }

    public function getMessageManager(): MessageManager
    {
        return $this->messageManager;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

    public function getPaths(): Paths
    {
        return $this->paths;
    }

}