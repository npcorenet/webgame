<?php

namespace App\Verify;

use App\Model\AccountModel;
use App\Table\AccountTable;
use App\Util\MessageManager;
use function PHPUnit\Framework\isEmpty;

class RegisterVerification
{

    public function __construct(private MessageManager $messageManager, private AccountTable $accountTable)
    {
    }

    public function verify(AccountModel $accountModel): bool
    {

        if(empty($accountModel->getUsername()))
        {
            $this->messageManager->add('danger', 'Der Nutzername darf nicht leer sein');
        }

        if(!filter_var($accountModel->getEmail(), FILTER_VALIDATE_EMAIL))
        {
            $this->messageManager->add('danger', 'Die angegebene E-Mail ist ungültig');
        }

        if(mb_strlen($accountModel->getPassword()) < 8)
        {
            $this->messageManager->add('danger', 'Das Passwort muss mindestens 8 Zeichen lang sein');
        }

        if(
            $this->accountTable->findByEmail($accountModel->getEmail()) !== FALSE
            ||
            $this->accountTable->findByUsername($accountModel->getUsername()) !== FALSE
        )
        {
            $this->messageManager->add('danger', 'Nutzername oder Email ist bereits vergeben');
        }

        return $this->messageManager->countType('danger') === 0;

    }

}