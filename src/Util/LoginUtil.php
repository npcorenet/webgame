<?php

namespace App\Util;

use App\Container;
use App\Table\AccountTable;

class LoginUtil
{

    private bool $isLoggedIn;
    private array $accountData;

    public function __construct(private Container $container)
    {
        $this->validateLogin();
    }

    public function validateLogin(): bool
    {

        $this->setIsLoggedIn(false);

        if(isset($_SESSION[$this->container->getPrefix().'loginId']))
        {

            $loginId = $_SESSION[$this->container->getPrefix().'loginId'];
            $accountTable = new AccountTable($this->container->getDatabase());

            $accountData = $accountTable->findById($loginId);

            if($loginId !== 0 && $accountData !== FALSE)
            {

                $this->setIsLoggedIn(true);

                $this->container->getTwig()->addGlobal('coins', $accountData['coins']);
                $this->container->getTwig()->addGlobal('diamond', $accountData['diamonds']);
                $this->container->getTwig()->addGlobal('userPermLevel', $accountData['type']);
                $this->container->getTwig()->addGlobal('username', $accountData['username']);
                $this->container->getTwig()->addGlobal('userId', $accountData['id']);
                $this->accountData = $accountData;

                return true;

            }

        }

        return false;

    }

    public function getIsLoggedIn(): bool
    {
        return $this->isLoggedIn;
    }

    public function setIsLoggedIn(bool $isLoggedIn): void
    {
        $this->container->getTwig()->addGlobal('isLoggedIn', $isLoggedIn);
        $this->isLoggedIn = $isLoggedIn;
    }

    public function getAccountData(): array
    {
        return $this->accountData;
    }

    public function getAccountPermissionLevel(): int
    {

        return $this->accountData['type'];

    }

    public function getLoginId(): int
    {

        return $_SESSION[$this->container->getPrefix().'loginId'];

    }

}