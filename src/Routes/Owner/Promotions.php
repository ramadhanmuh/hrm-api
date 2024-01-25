<?php

namespace Src\Routes\Owner;

use Src\Controllers\PromotionController;
use Src\Middleware\UserIsOwner;

class Promotions
{
    static $list = [
        'path' => 'promotions',
        'list' => [
            [
                'path' => '',
                'method' => 'POST',
                'controller' => PromotionController::class,
                'function' => 'create',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => PromotionController::class,
                'function' => 'list',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => PromotionController::class,
                'function' => 'count',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => PromotionController::class,
                'function' => 'update',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => PromotionController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => PromotionController::class,
                'function' => 'delete',
                'middleware' => [ UserIsOwner::class ]
            ],
        ]
    ];
}
