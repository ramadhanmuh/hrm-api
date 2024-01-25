<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class CountTerminationRequest
{
    public $input;

    function __construct() {
        $this->input = [
            'keyword' => RequestHelper::getStringParameter('keyword'),
            'id' => RequestHelper::getArrayParameter('id'),
            'employeeId' => RequestHelper::getArrayParameter('employeeId'),
            'terminationTypeId' => RequestHelper::getArrayParameter('terminationTypeId'),
            'startCreatedAt' => RequestHelper::getNumericParameter('startCreatedAt'),
            'endCreatedAt' => RequestHelper::getNumericParameter('endCreatedAt'),
            'startDate' => RequestHelper::getNumericParameter('startDate'),
            'endDate' => RequestHelper::getNumericParameter('endDate'),
            'startNoticeDate' => RequestHelper::getNumericParameter('startNoticeDate'),
            'endNoticeDate' => RequestHelper::getNumericParameter('endNoticeDate'),
        ];
    }
}
