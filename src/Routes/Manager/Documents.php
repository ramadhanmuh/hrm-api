<?php

namespace Src\Routes\Manager;

use Src\Controllers\DocumentController;
use Src\Middleware\UserIsManager;

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
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => DocumentController::class,
                'function' => 'list',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => DocumentController::class,
                'function' => 'count',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => DocumentController::class,
                'function' => 'update',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => DocumentController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => DocumentController::class,
                'function' => 'delete',
                'middleware' => [UserIsManager::class]
            ],
        ]
    ];
}
