<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class CountWorkHistoryRequest
{
    public $input;

    function __construct() {
        $this->input = [
            'keyword' => RequestHelper::getStringParameter('keyword'),
            'id' => RequestHelper::getArrayParameter('id'),
            'employeeId' => RequestHelper::getArrayParameter('employeeId'),
            'startCreatedAt' => RequestHelper::getNumericParameter('startCreatedAt'),
            'endCreatedAt' => RequestHelper::getNumericParameter('endCreatedAt'),
            'startDateOfJoin' => RequestHelper::getNumericParameter('startDateOfJoin'),
            'endDateOfJoin' => RequestHelper::getNumericParameter('endDateOfJoin'),
        ];
    }
}
