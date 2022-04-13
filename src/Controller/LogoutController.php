<?php

namespace App\Controller;

use App\Container;
use App\Interface\ControllerInterface;

class LogoutController implements ControllerInterface
{


    public function __construct(private Container $container)
    {
    }

    public function handle()
    {

        session_destroy();
        header("Location: " . $this->container->getPaths()->readAndOutputRequestedPath() . "/login");

    }

    public function get(): void
    {
    }

    public function post(): void
    {
    }
}