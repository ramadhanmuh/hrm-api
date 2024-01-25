<?php

namespace Src\Routes\Owner;

use Src\Controllers\DepartmentController;
use Src\Middleware\UserIsOwner;

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
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => DepartmentController::class,
                'function' => 'list',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => DepartmentController::class,
                'function' => 'count',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => DepartmentController::class,
                'function' => 'update',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => DepartmentController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => DepartmentController::class,
                'function' => 'delete',
                'middleware' => [UserIsOwner::class]
            ],
        ]
    ];
}
