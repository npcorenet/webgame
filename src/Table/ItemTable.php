<?php declare(strict_types=1);

namespace App\Table;

class ItemTable extends AbstractTable
{

    public function findAllByTypeId(int $id): array|bool
    {
        return $this->query->from($this->getTableName())->where(['typeId' => $id])->fetchAll();
    }

}