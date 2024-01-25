<?php

namespace Src\Routes\Manager;

use Src\Controllers\WorkHistoryController;
use Src\Middleware\UserIsManager;

class WorkHistories
{
    static $list = [
        'path' => 'work-histories',
        'list' => [
            [
                'path' => '',
                'method' => 'POST',
                'controller' => WorkHistoryController::class,
                'function' => 'create',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => WorkHistoryController::class,
                'function' => 'list',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => WorkHistoryController::class,
                'function' => 'count',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => WorkHistoryController::class,
                'function' => 'update',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => WorkHistoryController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => WorkHistoryController::class,
                'function' => 'delete',
                'middleware' => [ UserIsManager::class ]
            ],
        ]
    ];
}
