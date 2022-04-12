<?php

namespace App\Controller;

use App\ConfigProvider;
use App\Interface\ControllerInterface;
use App\Model\AccountModel;
use App\Table\AccountTable;
use App\Verify\LoginVerification;

class LoginController implements ControllerInterface
{

    public function __construct(private ConfigProvider $configProvider)
    {
    }

    public function handle()
    {

        if($this->configProvider->paths->getRequestType() === "POST")
        {

            $this->post();

        }

        echo $this->configProvider->twig->render('page/login.html.twig', ['messages' => $this->configProvider->messageManager->getMessageArray()]);

    }

    public function get()
    {
    }

    public function post()
    {

        if(isset($_POST['loginEmail'], $_POST['loginPassword']))
        {

            $accountTable = new AccountTable($this->configProvider->database);

            $accountModel = new AccountModel();
            $accountModel->setEmail($_POST['loginEmail']);
            $accountModel->setPassword($_POST['loginPassword']);

            $verify = new LoginVerification($this->configProvider->messageManager);

            if(!$verify->verify($accountModel))
            {
                return;
            }

            $accountData = $accountTable->findByEmail($accountModel->getEmail());

            if($accountData === FALSE)
            {
                $this->configProvider->messageManager->add('danger', 'Es wurde kein Konto mit diesen Daten gefunden');
                return;
            }

            if(!password_verify($accountModel->getPassword(), $accountData['password'])) {

                $this->configProvider->messageManager->add('danger', 'Es wurde kein Konto mit diesen Daten gefunden');
                return;

            }

            $accountModel->setId($accountData['id']);

            $_SESSION[$this->configProvider->get('prefix') . 'loginId'] = $accountModel->getId();

            $this->configProvider->messageManager->add('success', 'Anmeldung erfolgreich!');

        }

    }
}