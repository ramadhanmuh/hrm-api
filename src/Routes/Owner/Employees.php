<?php

namespace Src\Routes\Owner;

use Src\Controllers\EmployeeController;
use Src\Middleware\UserIsOwner;

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
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => EmployeeController::class,
                'function' => 'list',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => EmployeeController::class,
                'function' => 'count',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => EmployeeController::class,
                'function' => 'update',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => EmployeeController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => EmployeeController::class,
                'function' => 'delete',
                'middleware' => [UserIsOwner::class]
            ]
        ]
    ];
}
