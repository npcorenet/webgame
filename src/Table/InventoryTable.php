<?php declare(strict_types=1);

namespace App\Table;

use App\Model\InventoryModel;

class InventoryTable extends AbstractTable
{

    public function insert(InventoryModel $inventoryModel): bool|array
    {

        $values =
            [
                'userId' => $inventoryModel->getUserId(),
                'itemId' => $inventoryModel->getItemId(),
                'amount' => $inventoryModel->getAmount()
            ];

        return $this->query->insertInto($this->getTableName())->values($values)->execute();

    }

    public function updateAmount(int $userId, int $itemId, int $newAmount): bool|array
    {

        $values =
            [
                'userId' => $userId,
                'itemId' => $itemId,
            ];

        return $this->query->update($this->getTableName())->where($values)->set(['amount' => $newAmount])->execute();

    }

    public function getCountByIdAndUser(int $id, int $accountId): int
    {

        $values = ['itemId' => $id,
            'userId' => $accountId];

        $query = $this->query->from($this->getTableName())->where($values)->fetch();
        if($query !== FALSE)
        {
            return $query['amount'];
        }

        return -1;

    }

    public function findAllByItemId(int $id): bool|array
    {

        return $this->query->from($this->getTableName())->where(['itemId' => $id])->fetchAll();

    }

}