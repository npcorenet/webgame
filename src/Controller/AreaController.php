<?php

namespace App\Controller;

use App\Container;
use App\Interface\ControllerInterface;
use App\Model\InventoryModel;
use App\Service\InventoryService;
use App\Table\AccountTable;
use App\Table\AreaAccountTable;
use App\Table\AreaEarningTable;
use App\Table\AreaTable;
use App\Table\InventoryTable;

class AreaController implements ControllerInterface
{

    private array $content = [];

    public function __construct(private Container $container)
    {
    }

    public function handle()
    {

        if($this->container->getPaths()->getRequestType() === 'POST')
        {
            $this->post();
        }

        $this->get();

        echo $this->container->getTwig()->render('page/area.html.twig',
            array_merge(['messages' => $this->container->getMessageManager()->getMessageArray()], $this->content));

    }

    public function get(): void
    {

        $areaAccountTable = new AreaAccountTable($this->container->getDatabase());
        $areaTable = new AreaTable($this->container->getDatabase());

        $areaData = $areaAccountTable->findByUserId($this->container->areaId, $this->container->getLoginUtil()->getLoginId());

        if(count($areaData) === 0) { header("Location: ". $this->container->getPaths()->readAndOutputRequestedPath().'/'); }

        $areaTableData = $areaTable->findById($areaData[0]['areaId']);

        if($this->container->claim !== '')
        {
            $this->claim();
        }

        $this->content = array_merge(['title' => $areaTableData['title']]);

    }

    public function post(): void
    {
        // TODO: Implement post() method.
    }

    public function claim()
    {

        $areaEarningTable = new AreaEarningTable($this->container->getDatabase());
        $areaEarningData = $areaEarningTable->findAllByUserAndAreaId($this->container->getLoginUtil()->getLoginId(), $this->container->areaId);
        $accountTable = new AccountTable($this->container->getDatabase());
        $inventoryTable = new InventoryTable($this->container->getDatabase());
        $inventoryService = new InventoryService($inventoryTable);

        if(count($areaEarningData) > 0)
        {
            foreach ($areaEarningData as $item)
            {

                if($item['itemId'] > 0)
                {
                    $inventoryService->addItem($this->container->getLoginUtil()->getLoginId(), $item['itemId'], $item['count']);
                }

                if($item['itemId'] === -1)
                {
                    $accountTable->setCoins(((int)$accountTable->findById($item['userId'])['coins']) + $item['count'], $item['userId']);
                }

                $areaEarningTable->removeById($item['id']);

            }

            $this->container->getMessageManager()->add('success', 'Die Items wurden abgeholt!');
            return;
        }

        $this->container->getMessageManager()->add('danger', 'Es gibt nichts abzuholen!');

    }

}