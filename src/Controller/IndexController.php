<?php declare(strict_types=1);

namespace App\Controller;

use App\Container;
use App\Interface\ControllerInterface;

class IndexController implements ControllerInterface
{

    public function __construct(private Container $container)
    {
    }

    public function handle()
    {
        if($this->container->getPaths()->getRequestType() === 'POST')
        {

            $this->post();

        }

        if($this->container->getLoginUtil()->getIsLoggedIn())
        {
            echo $this->container->getTwig()->render('page/gameboard.html.twig');
            return;
        }

        echo $this->container->getTwig()->render('page/home.html.twig');

    }

    public function get(): void
    {}

    public function post(): void
    {}
}