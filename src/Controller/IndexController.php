<?php

namespace App\Controller;

use App\ConfigProvider;
use App\Interface\ControllerInterface;
use App\Table\AccountTable;

class IndexController implements ControllerInterface
{

    public function __construct(array $container)
    {
    }

    public function handle()
    {

        $content = [];

        if($this->configProvider->paths->getRequestType() === 'POST')
        {

            $content = $this->post();

        }

        echo $this->configProvider->twig->render('page/home.html.twig');

    }

    public function get()
    {

        return [];

    }

    public function post(): array
    {

        return [];

    }
}