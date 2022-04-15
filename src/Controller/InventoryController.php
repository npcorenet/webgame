<?php

namespace App\Controller;

use App\Container;
use App\Interface\ControllerInterface;
use App\Service\InventoryService;
use App\Table\InventoryTable;
use App\Table\ItemTable;
use App\Table\ItemTypeTable;

class InventoryController implements ControllerInterface
{

    private array $content = [];

    public function __construct(private Container $container)
    {
    }

    public function handle()
    {

        $this->get();

        echo $this->container->getTwig()->render('page/inventory.html.twig', $this->content);

    }

    public function get(): void
    {

        $itemTypeTable = new ItemTypeTable($this->container->getDatabase());
        $itemTable = new ItemTable($this->container->getDatabase());
        $inventoryTable = new InventoryTable($this->container->getDatabase());
        $inventoryService = new InventoryService($inventoryTable);

        $content = [];

        foreach ($itemTypeTable->findAll() as $itemType)
        {

            $itemList = [];

            if($itemType['id'] !== 8)
            {

                foreach ($itemTable->findAllByTypeId($itemType['id']) as $item) {

                    $count = $inventoryService->getItemAmount($this->container->getLoginUtil()->getLoginId(), $item['id']);

                    $itemList[] = array_merge($item, ['count' => $count]);

                }

                $content['groups'][] = array_merge($itemType, ['items' => $itemList]);

            }

        }

        $this->content = $content;

    }

    public function post(): void
    {
        // TODO: Implement post() method.
    }
}