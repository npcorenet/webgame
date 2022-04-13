<?php

namespace App\AdminController;

use App\Container;
use App\Interface\ControllerInterface;

class ItemController implements ControllerInterface
{

    public function __construct(private Container $container)
    {
    }

    public function handle()
    {

        echo $this->container->getTwig()->render('admin/page/items.html.twig');

    }

    public function get(): void
    {
        // TODO: Implement get() method.
    }

    public function post(): void
    {
        // TODO: Implement post() method.
    }
}