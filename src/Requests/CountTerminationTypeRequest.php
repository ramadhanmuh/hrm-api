<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class CountTerminationTypeRequest
{
    public $input;

    function __construct() {
        $this->input = [
            'keyword' => RequestHelper::getStringParameter('keyword'),
            'id' => RequestHelper::getArrayParameter('id'),
            'startCreatedAt' => RequestHelper::getNumericParameter('startCreatedAt'),
            'endCreatedAt' => RequestHelper::getNumericParameter('endCreatedAt'),
        ];
    }
}
