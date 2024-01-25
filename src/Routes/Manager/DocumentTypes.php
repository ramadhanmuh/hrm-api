<?php

namespace Src\Routes\Manager;

use Src\Controllers\DocumentTypeController;
use Src\Middleware\UserIsManager;

class DocumentTypes
{
    static $list = [
        'path' => 'document-types',
        'list' => [
            [
                'path' => '',
                'method' => 'GET',
                'controller' => DocumentTypeController::class,
                'function' => 'list',
                'middleware' => [UserIsManager::class]
            ]
        ]
    ];
}
