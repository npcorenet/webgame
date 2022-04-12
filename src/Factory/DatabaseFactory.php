<?php

namespace App\Factory;

use Envms\FluentPDO\Query;
use PDO;

class DatabaseFactory
{

    public function build(PDO $database): Query
    {

        return new Query($database);

    }

}