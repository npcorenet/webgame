<?php

namespace App\Table;

use App\Model\InventoryModel;

class InventoryTable extends AbstractTable
{

    public function insert(InventoryModel $inventoryModel): bool|array
    {

        $values =
            [
                'userId' => $inventoryModel->getUserId(),
                'itemId' => $inventoryModel->getItemId()
            ];

        return $this->query->insertInto($this->getTableName())->values($values)->execute();

    }

    public function getCountByIdAndUser(int $id, int $accountId): int
    {

        $values = ['itemId' => $id,
            'userId' => $accountId];

        return $this->query->from($this->getTableName())->select(null)->select('COUNT(*)')->where($values)->fetchColumn();

    }

    public function findAllByItemId(int $id): bool|array
    {

        return $this->query->from($this->getTableName())->where(['itemId' => $id])->fetchAll();

    }

}