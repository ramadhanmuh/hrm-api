<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class CountDepartmentRequest
{
    public $input;

    function __construct() {
        $this->input = [
            'keyword' => RequestHelper::getStringParameter('keyword'),
            'id' => RequestHelper::getArrayParameter('id'),
            'branchId' => RequestHelper::getArrayParameter('branchId'),
            'startCreatedAt' => RequestHelper::getNumericParameter('startCreatedAt'),
            'endCreatedAt' => RequestHelper::getNumericParameter('endCreatedAt')
        ];
    }
}
