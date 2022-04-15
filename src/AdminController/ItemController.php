<?php declare(strict_types=1);

namespace App\AdminController;

use App\Container;
use App\Interface\ControllerInterface;
use App\Table\ItemTable;
use App\Table\ItemTypeTable;

class ItemController implements ControllerInterface
{

    private array $values = [];

    public function __construct(private Container $container)
    {
    }

    public function handle()
    {

        $this->get();

        echo $this->container->getTwig()->render('admin/page/items.html.twig',
            array_merge(['messages' => $this->container->getMessageManager()->getMessageArray()], $this->values));

    }

    public function get(): void
    {

        $itemTable = new ItemTable($this->container->getDatabase());

        $output = [];
        foreach ($itemTable->findAll() as $item)
        {

            $itemTypeTable = new ItemTypeTable($this->container->getDatabase());
            $output[] = array_merge($item, ['type' => $itemTypeTable->findById($item['typeId'])['title']]);


        }

        $this->values = array_merge($this->values, ['items' => $output]);

    }

    public function post(): void
    {
        // TODO: Implement post() method.
    }
}