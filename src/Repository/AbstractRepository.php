<?php

namespace App\Repository;

use App\Application\Config;

abstract class AbstractRepository
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
}
