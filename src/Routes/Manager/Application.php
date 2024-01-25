<?php

namespace Src\Routes\Manager;

use Src\Controllers\ApplicationController;
use Src\Middleware\UserIsManager;

class Application
{
    static $list = [
        'path' => 'application',
        'list' => [
            [
                'path' => '',
                'method' => 'PUT',
                'controller' => ApplicationController::class,
                'function' => 'update',
                'middleware' => [UserIsManager::class]
            ],
        ]
    ];
}
