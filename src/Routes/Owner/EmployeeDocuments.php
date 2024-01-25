<?php

namespace Src\Routes\Owner;

use Src\Controllers\EmployeeDocumentController;
use Src\Middleware\UserIsOwner;

class EmployeeDocuments
{
    static $list = [
        'path' => 'employee-documents',
        'list' => [
            [
                'path' => '',
                'method' => 'POST',
                'controller' => EmployeeDocumentController::class,
                'function' => 'create',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => EmployeeDocumentController::class,
                'function' => 'list',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => EmployeeDocumentController::class,
                'function' => 'count',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => EmployeeDocumentController::class,
                'function' => 'update',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => EmployeeDocumentController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => EmployeeDocumentController::class,
                'function' => 'delete',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '$',
                'list' => [
                    [
                        'path' => 'open',
                        'method' => 'GET',
                        'controller' => EmployeeDocumentController::class,
                        'function' => 'open',
                        'middleware' => [ UserIsOwner::class ],
                    ]
                ]
            ],
        ]
    ];
}
