<?php

namespace Src\Routes\Manager;

use Src\Controllers\DepartmentController;
use Src\Middleware\UserIsManager;

class Departments
{
    static $list = [
        'path' => 'departments',
        'list' => [
            [
                'path' => '',
                'method' => 'POST',
                'controller' => DepartmentController::class,
                'function' => 'create',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => DepartmentController::class,
                'function' => 'list',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => DepartmentController::class,
                'function' => 'count',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => DepartmentController::class,
                'function' => 'update',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => DepartmentController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => DepartmentController::class,
                'function' => 'delete',
                'middleware' => [UserIsManager::class]
            ],
        ]
    ];
}
