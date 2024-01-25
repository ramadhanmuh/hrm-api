<?php

namespace Src\Routes\Employee;

use Src\Controllers\TransferController;
use Src\Middleware\UserIsEmployee;

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
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => TransferController::class,
                'function' => 'list',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => TransferController::class,
                'function' => 'count',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => TransferController::class,
                'function' => 'update',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => TransferController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => TransferController::class,
                'function' => 'delete',
                'middleware' => [ UserIsEmployee::class ]
            ],
        ]
    ];
}
