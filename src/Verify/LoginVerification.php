<?php declare(strict_types=1);

namespace App\Verify;

use App\Model\AccountModel;
use App\Util\MessageManager;

class LoginVerification
{

    public function __construct(private MessageManager $messageManager)
    {
    }

    public function verify(AccountModel $accountModel): bool
    {

        if(!filter_var($accountModel->getEmail(), FILTER_VALIDATE_EMAIL))
        {
            $this->messageManager->add('danger', 'Die Email ist ungültig');
        }

        if(empty($accountModel->getPassword()))
        {
            $this->messageManager->add('danger', 'Das Passwort darf nicht leer sein');
        }

        return $this->messageManager->countType('danger') === 0;

    }

}