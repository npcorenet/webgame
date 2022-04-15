<?php declare(strict_types=1);

namespace App\Table;

class AreaTable extends AbstractTable
{

    public function findUnlockableAreasByLevel(int $level): array|bool
    {

        return $this->query->from($this->getTableName())->where('minlevel >= ?', $level)->fetchAll();

    }

}