<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class CountEmployeeDocumentRequest
{
    public $input;

    function __construct() {
        $this->input = [
            'keyword' => RequestHelper::getStringParameter('keyword'),
            'id' => RequestHelper::getArrayParameter('id'),
            'employeeId' => RequestHelper::getArrayParameter('employeeId'),
            'documentId' => RequestHelper::getArrayParameter('documentId'),
            'startCreatedAt' => RequestHelper::getNumericParameter('startCreatedAt'),
            'endCreatedAt' => RequestHelper::getNumericParameter('endCreatedAt'),
        ];
    }
}
