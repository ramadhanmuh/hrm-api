<?php

namespace Src\Routes;

use Src\Controllers\ApplicationController;

class Application
{
    static $list = [
        'path' => '',
        'method' => 'GET',
        'controller' => ApplicationController::class,
        'function' => 'get',
        'middleware' => []
    ];
}
