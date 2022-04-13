<?php

namespace App\Controller;

use App\ConfigProvider;
use App\Container;
use App\Interface\ControllerInterface;
use App\Model\AccountModel;
use App\Table\AccountTable;
use App\Util\MessageManager;
use App\Verify\RegisterVerification;
use DateTime;

class RegisterController implements ControllerInterface
{

    public function __construct(private Container $container)
    {
    }

    public function handle()
    {

        $content = [];

        if($this->container->getPaths()->getRequestType() === 'POST')
        {
            $this->post();
        }

        echo $this->container->getTwig()->render('page/register.html.twig', ['messages' => $this->container->getMessageManager()->getMessageArray()]);

    }

    public function get(): void
    {
    }

    public function post(): void
    {

        if(isset($_POST['registerEmail'], $_POST['registerPassword'], $_POST['registerUsername']))
        {

            $table = new AccountTable($this->container->getDatabase());

            $model = new AccountModel();
            $model->setEmail($_POST['registerEmail']);
            $model->setUsername($_POST['registerUsername']);
            $model->setPassword($_POST['registerPassword']);
            $model->setRegistered(new DateTime());

            $verify = new RegisterVerification($this->container->getMessageManager(), $table);

            if(!$verify->verify($model))
            {
                return;
            }

            if($table->insert($model))
            {
                $this->container->getMessageManager()->add('success', 'Das Benutzerkonto wurde erfolgreich angelegt!');
                return;
            }

            $this->container->getMessageManager()->add('danger', 'Ein Fehler ist aufgetreten!');
        }

    }
}