<?php

namespace Src\Routes\Owner;

use Src\Controllers\TransferController;
use Src\Middleware\UserIsOwner;

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
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => TransferController::class,
                'function' => 'list',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => TransferController::class,
                'function' => 'count',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => TransferController::class,
                'function' => 'update',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => TransferController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => TransferController::class,
                'function' => 'delete',
                'middleware' => [ UserIsOwner::class ]
            ],
        ]
    ];
}
