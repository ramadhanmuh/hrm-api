<?php

namespace Src\Routes\Owner;

use Src\Controllers\DocumentController;
use Src\Middleware\UserIsOwner;

class Documents
{
    static $list = [
        'path' => 'documents',
        'list' => [
            [
                'path' => '',
                'method' => 'POST',
                'controller' => DocumentController::class,
                'function' => 'create',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => DocumentController::class,
                'function' => 'list',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => DocumentController::class,
                'function' => 'count',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => DocumentController::class,
                'function' => 'update',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => DocumentController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => DocumentController::class,
                'function' => 'delete',
                'middleware' => [UserIsOwner::class]
            ],
        ]
    ];
}
