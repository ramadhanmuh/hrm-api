<?php

namespace Src\Routes\Owner;

use Src\Controllers\DocumentTypeController;
use Src\Middleware\UserIsOwner;

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
                'middleware' => [UserIsOwner::class]
            ]
        ]
    ];
}
