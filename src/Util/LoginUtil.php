<?php

namespace App\Util;

use App\Model\AccountModel;
use App\Table\AccountTable;
use Twig\Environment;

class LoginUtil
{

    private AccountModel $accountModel;

    public function __construct(private string $prefix, private Environment $twig, private AccountTable $accountTable)
    {
        if(isset($_SESSION[$prefix.'loginId']) && $_SESSION[$prefix.'loginId'] > 0)
        {
            $this->accountModel = new AccountModel();
            $this->accountModel->setId($_SESSION[$this->prefix.'loginId']);

            $data = $this->accountTable->findById($this->accountModel->getId());

            if($data === FALSE) {
                session_destroy();
                return;
            }

            $this->twig->addGlobal('isLoggedIn', true);
            return;

        }

        $this->twig->addGlobal('isLoggedIn', false);

    }

    public function getAccount(): AccountModel
    {
        return $this->accountModel;
    }

}