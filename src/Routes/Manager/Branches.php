<?php

namespace Src\Routes\Manager;

use Src\Controllers\BranchController;
use Src\Middleware\UserIsManager;

class Branches
{
    static $list = [
        'path' => 'branches',
        'list' => [
            [
                'path' => '',
                'method' => 'GET',
                'controller' => BranchController::class,
                'function' => 'list',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => BranchController::class,
                'function' => 'count',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '',
                'method' => 'POST',
                'controller' => BranchController::class,
                'function' => 'create',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => BranchController::class,
                'function' => 'update',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => BranchController::class,
                'function' => 'delete',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => BranchController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsManager::class ]
            ],
        ]
    ];
}
