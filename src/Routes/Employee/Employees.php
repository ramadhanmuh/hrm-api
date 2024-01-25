<?php

namespace Src\Routes\Employee;

use Src\Controllers\EmployeeController;
use Src\Middleware\UserIsEmployee;

class Employees
{
    static $list = [
        'path' => 'employees',
        'list' => [
            [
                'path' => '',
                'method' => 'POST',
                'controller' => EmployeeController::class,
                'function' => 'create',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => EmployeeController::class,
                'function' => 'list',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => EmployeeController::class,
                'function' => 'count',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => EmployeeController::class,
                'function' => 'update',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => EmployeeController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => EmployeeController::class,
                'function' => 'delete',
                'middleware' => [UserIsEmployee::class]
            ]
        ]
    ];
}
