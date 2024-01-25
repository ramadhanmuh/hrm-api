<?php

namespace Src\Routes\Owner;

use Src\Controllers\WorkHistoryController;
use Src\Middleware\UserIsOwner;

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
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => WorkHistoryController::class,
                'function' => 'list',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => WorkHistoryController::class,
                'function' => 'count',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => WorkHistoryController::class,
                'function' => 'update',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => WorkHistoryController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => WorkHistoryController::class,
                'function' => 'delete',
                'middleware' => [ UserIsOwner::class ]
            ],
        ]
    ];
}
