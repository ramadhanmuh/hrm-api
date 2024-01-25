<?php

namespace Src\Routes\Employee;

use Src\Controllers\DepartmentController;
use Src\Middleware\UserIsEmployee;

class Departments
{
    static $list = [
        'path' => 'departments',
        'list' => [
            [
                'path' => '',
                'method' => 'GET',
                'controller' => DepartmentController::class,
                'function' => 'list',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => DepartmentController::class,
                'function' => 'count',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => DepartmentController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsEmployee::class ]
            ],
        ]
    ];
}
