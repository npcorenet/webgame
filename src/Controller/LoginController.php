<?php

namespace App\Controller;

use App\Container;
use App\Interface\ControllerInterface;
use App\Model\AccountModel;
use App\Table\AccountTable;
use App\Verify\LoginVerification;

class LoginController implements ControllerInterface
{

    public function __construct(private Container $container)
    {
    }

    public function handle()
    {

        if($this->container->getPaths()->getRequestType() === "POST") { $this->post(); }

        echo $this->container->getTwig()->render('page/login.html.twig', ['messages' => $this->container->getMessageManager()->getMessageArray()]);

    }

    public function get(): void
    {
    }

    public function post(): void
    {

        if(isset($_POST['loginEmail'], $_POST['loginPassword']))
        {

            $accountTable = new AccountTable($this->container->getDatabase());

            $accountModel = new AccountModel();
            $accountModel->setEmail($_POST['loginEmail']);
            $accountModel->setPassword($_POST['loginPassword']);

            $verify = new LoginVerification($this->container->getMessageManager());

            if(!$verify->verify($accountModel))
            {
                return;
            }

            $accountData = $accountTable->findByEmail($accountModel->getEmail());

            if($accountData === FALSE)
            {
                $this->container->getMessageManager()->add('danger', 'Es wurde kein Konto mit diesen Daten gefunden');
                return;
            }

            if(!password_verify($accountModel->getPassword(), $accountData['password'])) {

                $this->container->getMessageManager()->add('danger', 'Es wurde kein Konto mit diesen Daten gefunden');
                return;

            }

            $accountModel->setId($accountData['id']);

            $_SESSION[$this->container->getPrefix() . 'loginId'] = $accountModel->getId();

            $this->container->getMessageManager()->add('success', 'Anmeldung erfolgreich!');

            header("Location: " . $this->container->getPaths()->readAndOutputRequestedPath() . "/");

        }

    }
}