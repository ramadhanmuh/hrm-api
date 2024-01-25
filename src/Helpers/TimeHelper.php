<?php

namespace Src\Helpers;

use Src\Configurations\Environment;

class TimeHelper
{
    static function createTimeNow() {
        date_default_timezone_set(Environment::$value['timezone']);

        return time();
    }

    static function createDateNow($format = 'Y-m-d H:i:s') {
        date_default_timezone_set(Environment::$value['timezone']);

        return date($format);
    }
}
