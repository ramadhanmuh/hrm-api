<?php

namespace Src\Models;

use Src\Helpers\TimeHelper;
use Src\Systems\Model;

class UserToken extends Model
{
    static $table = 'user_tokens',
        $columns = 'userId, token, expiredAt, createdAt';

    static function getWithUserByActiveToken($token) {
        parent::setQuery(
            'SELECT
                userId, role
            FROM
                ' . self::$table . '
            INNER JOIN
                ' . User::$table . '
            ON
                ' . self::$table . '.userId = ' . User::$table . '.id
            WHERE
                token = :token
            AND
                ' . self::$table . '.expiredAt > ' . TimeHelper::createTimeNow() . '
            AND
                ' . User::$table . '.status = 1
            LIMIT 1'
        );

        parent::setParameter(':token', $token);

        return parent::getOne();
    }
}
