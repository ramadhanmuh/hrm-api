<?php

namespace Src\Routes\Manager;

use Src\Controllers\DesignationController;
use Src\Middleware\UserIsManager;

class Designations
{
    static $list = [
        'path' => 'designations',
        'list' => [
            [
                'path' => '',
                'method' => 'POST',
                'controller' => DesignationController::class,
                'function' => 'create',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => DesignationController::class,
                'function' => 'list',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => DesignationController::class,
                'function' => 'count',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => DesignationController::class,
                'function' => 'update',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => DesignationController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => DesignationController::class,
                'function' => 'delete',
                'middleware' => [UserIsManager::class]
            ],
        ]
    ];
}
