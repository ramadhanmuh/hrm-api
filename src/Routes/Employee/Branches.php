<?php

namespace Src\Routes\Employee;

use Src\Controllers\BranchController;
use Src\Middleware\UserIsEmployee;

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
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => BranchController::class,
                'function' => 'count',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => BranchController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsEmployee::class ]
            ],
        ]
    ];
}
