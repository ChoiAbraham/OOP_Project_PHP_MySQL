<?php

namespace App\Helper\Ajax;

use App\Core\App;
use App\Helper\Factory\RepositoryFactory;

/**
 * uses Repository Instances
 */
class AbstractAjaxRequest extends RepositoryFactory
{
    public function __construct()
    {
        parent::__construct();
    }
}
