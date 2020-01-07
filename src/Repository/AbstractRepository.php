<?php

namespace App\Repository;

use App\Application\Config;
use App\Core\Singleton;

abstract class AbstractRepository extends Singleton
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
}
