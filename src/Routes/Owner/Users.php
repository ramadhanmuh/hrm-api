<?php

namespace Src\Routes\Owner;

use Src\Controllers\Owner\UserController;
use Src\Middleware\UserIsOwner;

class Users
{
    static $list = [
        'path' => 'users',
        'list' => [
            [
                'path' => '',
                'method' => 'GET',
                'controller' => UserController::class,
                'function' => 'list',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '',
                'method' => 'POST',
                'controller' => UserController::class,
                'function' => 'create',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => UserController::class,
                'function' => 'count',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => UserController::class,
                'function' => 'update',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => UserController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => UserController::class,
                'function' => 'delete',
                'middleware' => [UserIsOwner::class]
            ],
        ]
    ];
}
