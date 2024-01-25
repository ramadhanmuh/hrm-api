<?php

namespace Src\Routes\Manager;

use Src\Controllers\TransferController;
use Src\Middleware\UserIsManager;

class Transfers
{
    static $list = [
        'path' => 'transfers',
        'list' => [
            [
                'path' => '',
                'method' => 'POST',
                'controller' => TransferController::class,
                'function' => 'create',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => TransferController::class,
                'function' => 'list',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => TransferController::class,
                'function' => 'count',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => TransferController::class,
                'function' => 'update',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => TransferController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => TransferController::class,
                'function' => 'delete',
                'middleware' => [ UserIsManager::class ]
            ],
        ]
    ];
}
