<?php

namespace Src\Routes\Employee;

use Src\Controllers\TerminationController;
use Src\Middleware\UserIsEmployee;

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
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => TerminationController::class,
                'function' => 'list',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => TerminationController::class,
                'function' => 'count',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => TerminationController::class,
                'function' => 'update',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => TerminationController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => TerminationController::class,
                'function' => 'delete',
                'middleware' => [ UserIsEmployee::class ]
            ],
        ]
    ];
}
