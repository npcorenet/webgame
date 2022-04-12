<?php

namespace App\Controller;

use App\ConfigProvider;
use App\Interface\ControllerInterface;

class IndexController implements ControllerInterface
{

    public function __construct(private ConfigProvider $configProvider)
    {
    }

    public function handle()
    {

        echo $this->configProvider->twig->render('page/home.html.twig');

    }

    public function get()
    {
        // TODO: Implement get() method.
    }

    public function post()
    {
        // TODO: Implement post() method.
    }
}