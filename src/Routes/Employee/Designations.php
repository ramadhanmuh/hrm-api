<?php

namespace Src\Routes\Employee;

use Src\Controllers\DesignationController;
use Src\Middleware\UserIsEmployee;

class Designations
{
    static $list = [
        'path' => 'designations',
        'list' => [
            [
                'path' => '',
                'method' => 'GET',
                'controller' => DesignationController::class,
                'function' => 'list',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => DesignationController::class,
                'function' => 'count',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => DesignationController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsEmployee::class ]
            ],
        ]
    ];
}
