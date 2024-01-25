<?php

namespace Src\Routes\Manager;

use Src\Controllers\EmployeeController;
use Src\Middleware\UserIsManager;

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
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => EmployeeController::class,
                'function' => 'list',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => EmployeeController::class,
                'function' => 'count',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => EmployeeController::class,
                'function' => 'update',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => EmployeeController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => EmployeeController::class,
                'function' => 'delete',
                'middleware' => [UserIsManager::class]
            ]
        ]
    ];
}
