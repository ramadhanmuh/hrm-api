<?php

namespace Src\Routes\Employee;

use Src\Controllers\ProfileController;
use Src\Middleware\UserIsEmployee;

class Profile
{
    static $list = [
        'path' => 'profile',
        'list' => [
            [
                'path' => '',
                'method' => 'GET',
                'controller' => ProfileController::class,
                'function' => 'get',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => '',
                'method' => 'PUT',
                'controller' => ProfileController::class,
                'function' => 'update',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => '',
                'method' => 'DELETE',
                'controller' => ProfileController::class,
                'function' => 'delete',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => 'change-password',
                'method' => 'PUT',
                'controller' => ProfileController::class,
                'function' => 'updatePassword',
                'middleware' => [UserIsEmployee::class]
            ]
        ]
    ];
}
