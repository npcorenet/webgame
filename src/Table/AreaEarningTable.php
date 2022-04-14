<?php

namespace App\Table;

class AreaEarningTable extends AbstractTable
{

    public function findAllByUserAndAreaId(int $userId, int $areaId): array|bool
    {

        $values = [
            'userId' => $userId,
            'areaId' => $areaId
        ];

        return $this->query->from($this->getTableName())->where($values)->fetchAll();

    }

}