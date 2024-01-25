<?php

namespace Src\Routes\Employee;

use Src\Controllers\WorkHistoryController;
use Src\Middleware\UserIsEmployee;

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
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => WorkHistoryController::class,
                'function' => 'list',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => WorkHistoryController::class,
                'function' => 'count',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => WorkHistoryController::class,
                'function' => 'update',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => WorkHistoryController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => WorkHistoryController::class,
                'function' => 'delete',
                'middleware' => [ UserIsEmployee::class ]
            ],
        ]
    ];
}
