<?php

namespace Src\Routes\Owner;

use Src\Controllers\TerminationController;
use Src\Middleware\UserIsOwner;

class Terminations
{
    static $list = [
        'path' => 'terminations',
        'list' => [
            [
                'path' => '',
                'method' => 'POST',
                'controller' => TerminationController::class,
                'function' => 'create',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => TerminationController::class,
                'function' => 'list',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => TerminationController::class,
                'function' => 'count',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => TerminationController::class,
                'function' => 'update',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => TerminationController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => TerminationController::class,
                'function' => 'delete',
                'middleware' => [ UserIsOwner::class ]
            ],
        ]
    ];
}
