<?php

namespace Src\Routes\Employee;

use Src\Controllers\TerminationTypeController;
use Src\Middleware\UserIsEmployee;

class TerminationTypes
{
    static $list = [
        'path' => 'termination-types',
        'list' => [
            [
                'path' => '',
                'method' => 'GET',
                'controller' => TerminationTypeController::class,
                'function' => 'list',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => TerminationTypeController::class,
                'function' => 'count',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => TerminationTypeController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsEmployee::class ]
            ],
        ]
    ];
}
