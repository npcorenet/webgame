<?php

namespace App\Util;

use App\ConfigProvider;
use App\Model\AccountModel;
use App\Table\AccountTable;

class LoginUtil
{

    private AccountModel $accountModel;

    public function __construct(private ConfigProvider $configProvider, private AccountTable $accountTable)
    {
        if(isset($_SESSION[$this->configProvider->get('prefix').'loginId']) && $_SESSION[$this->configProvider->get('prefix').'loginId'] > 0)
        {
            $this->accountModel = new AccountModel();
            $this->accountModel->setId($_SESSION[$this->configProvider->get('prefix').'loginId']);

            $data = $this->accountTable->findById($this->accountModel->getId());

            if($data === FALSE) {
                session_destroy();
                return;
            }

            $this->configProvider->twig->addGlobal('isLoggedIn', true);
            return;

        }

        $this->configProvider->twig->addGlobal('isLoggedIn', false);

    }

    public function getAccount(): AccountModel
    {
        return $this->accountModel;
    }

}