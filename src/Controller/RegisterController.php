<?php

namespace App\Controller;

use App\ConfigProvider;
use App\Interface\ControllerInterface;
use App\Model\AccountModel;
use App\Table\AccountTable;
use App\Util\MessageManager;
use App\Verify\RegisterVerification;
use DateTime;

class RegisterController implements ControllerInterface
{

    public function __construct(private ConfigProvider $configProvider, private MessageManager $messageManager = new MessageManager())
    {
    }

    public function handle()
    {

        $content = [];

        if($this->configProvider->paths->getRequestType() === 'POST')
        {
            $this->post();
        }

        $content = array_merge(['messages' => $this->messageManager->getMessageArray()], []);

        echo $this->configProvider->twig->render('page/register.html.twig', $content);

    }

    public function get(): void
    {

    }

    public function post(): void
    {

        if(isset($_POST['registerEmail'], $_POST['registerPassword'], $_POST['registerUsername']))
        {

            $table = new AccountTable($this->configProvider->database);

            $model = new AccountModel();
            $model->setEmail($_POST['registerEmail']);
            $model->setUsername($_POST['registerUsername']);
            $model->setPassword($_POST['registerPassword']);
            $model->setRegistered(new DateTime());

            $verify = new RegisterVerification($this->messageManager, $table);

            if(!$verify->verify($model))
            {
                return;
            }

            if($table->insert($model))
            {
                $this->messageManager->add('success', 'Das Benutzerkonto wurde erfolgreich angelegt!');
                return;
            }

            $this->messageManager->add('danger', 'Ein Fehler ist aufgetreten!');
        }

    }
}