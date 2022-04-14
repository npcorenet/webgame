<?php

namespace App\Table;

class InventoryTable extends AbstractTable
{

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