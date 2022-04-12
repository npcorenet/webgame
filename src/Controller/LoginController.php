<?php

namespace App\Controller;

use App\ConfigProvider;
use App\Interface\ControllerInterface;

class LoginController implements ControllerInterface
{

    public function __construct(private ConfigProvider $configProvider)
    {
    }

    public function handle()
    {
        // TODO: Implement handle() method.
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