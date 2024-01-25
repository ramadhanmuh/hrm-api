<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class CountTransferRequest
{
    public $input;

    function __construct() {
        $this->input = [
            'keyword' => RequestHelper::getStringParameter('keyword'),
            'id' => RequestHelper::getArrayParameter('id'),
            'employeeId' => RequestHelper::getArrayParameter('employeeId'),
            'designationId' => RequestHelper::getArrayParameter('designationId'),
            'startCreatedAt' => RequestHelper::getNumericParameter('startCreatedAt'),
            'endCreatedAt' => RequestHelper::getNumericParameter('endCreatedAt'),
            'startDate' => RequestHelper::getNumericParameter('startDate'),
            'endDate' => RequestHelper::getNumericParameter('endDate'),
        ];
    }
}
