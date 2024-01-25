<?php

namespace Src\Routes\Owner;

use Src\Controllers\BranchController;
use Src\Middleware\UserIsOwner;

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
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => BranchController::class,
                'function' => 'count',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '',
                'method' => 'POST',
                'controller' => BranchController::class,
                'function' => 'create',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => BranchController::class,
                'function' => 'update',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => BranchController::class,
                'function' => 'delete',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => BranchController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsOwner::class ]
            ],
        ]
    ];
}
