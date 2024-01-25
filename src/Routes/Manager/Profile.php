<?php

namespace Src\Routes\Manager;

use Src\Controllers\ProfileController;
use Src\Middleware\UserIsManager;

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
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '',
                'method' => 'PUT',
                'controller' => ProfileController::class,
                'function' => 'update',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '',
                'method' => 'DELETE',
                'controller' => ProfileController::class,
                'function' => 'delete',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => 'change-password',
                'method' => 'PUT',
                'controller' => ProfileController::class,
                'function' => 'updatePassword',
                'middleware' => [UserIsManager::class]
            ]
        ]
    ];
}
