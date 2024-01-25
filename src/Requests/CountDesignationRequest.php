<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class CountDesignationRequest
{
    public $input;

    function __construct() {
        $this->input = [
            'keyword' => RequestHelper::getStringParameter('keyword'),
            'id' => RequestHelper::getArrayParameter('id'),
            'departmentId' => RequestHelper::getArrayParameter('departmentId'),
            'startCreatedAt' => RequestHelper::getNumericParameter('startCreatedAt'),
            'endCreatedAt' => RequestHelper::getNumericParameter('endCreatedAt')
        ];
    }
}
