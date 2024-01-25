<?php

namespace Src\Routes\Owner;

use Src\Controllers\ProfileController;
use Src\Middleware\UserIsOwner;

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
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '',
                'method' => 'PUT',
                'controller' => ProfileController::class,
                'function' => 'update',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '',
                'method' => 'DELETE',
                'controller' => ProfileController::class,
                'function' => 'delete',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => 'change-password',
                'method' => 'PUT',
                'controller' => ProfileController::class,
                'function' => 'updatePassword',
                'middleware' => [UserIsOwner::class]
            ]
        ]
    ];
}
