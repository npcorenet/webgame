<?php

namespace App\Service;

use App\Model\InventoryModel;
use App\Table\AccountTable;
use App\Table\InventoryTable;
use App\Table\ItemTable;
use Envms\FluentPDO\Query;

class InventoryService
{

    public function __construct(private InventoryTable $inventoryTable)
    {
    }

    public function addItem(int $userId, int $itemId, int $amount = 1): bool
    {

        $value = $this->getItemAmount($userId, $itemId, true);

        if($value !== -1)
        {

            $newValue = $value + $amount;
            return $this->inventoryTable->updateAmount($userId, $itemId, $newValue);

        }

        $inventoryModel = new InventoryModel();

        $inventoryModel->setUserId($userId);
        $inventoryModel->setItemId($itemId);
        $inventoryModel->setAmount($amount);

        return $this->inventoryTable->insert($inventoryModel);

    }

    public function getItemAmount(int $userId, int $itemId, bool $getReal = false): int
    {

        $value = $this->inventoryTable->getCountByIdAndUser($itemId, $userId);

        if($getReal)
        {
            return $value;
        }

        if($value < 0)
        {
               $value = 0;
        }

        return $value;

    }

    public function takeItem(int $userId, int $itemId, int $amount): bool
    {

        $maxAmount = $this->getItemAmount($userId, $itemId);
        if($maxAmount < $amount)
        {
            return false;
        }

        return $this->inventoryTable->updateAmount($userId, $itemId, $maxAmount - $amount);

    }

}