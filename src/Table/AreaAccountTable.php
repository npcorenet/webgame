<?php

namespace App\Table;

class AreaAccountTable extends AbstractTable
{

    public function findAllByUserId(int $userId): bool|array
    {

        return $this->query->from($this->getTableName())->where(['userId' => $userId])->fetchAll();

    }

    public function findByUserId(int $areaId, int $userId): bool|array
    {

        return $this->query->from($this->getTableName())->where(['areaId' => $areaId, 'userId' => $userId])->fetchAll();

    }

}