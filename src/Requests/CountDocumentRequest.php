<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class CountDocumentRequest
{
    public $input;
    private $availableStatus = ['1', '0'];

    function __construct() {
        $this->input = [
            'keyword' => RequestHelper::getStringParameter('keyword'),
            'id' => RequestHelper::getArrayParameter('id'),
            'status' => RequestHelper::getStringParameterWithAvailableValue(
                'status', $this->availableStatus
            ),
            'startCreatedAt' => RequestHelper::getNumericParameter('startCreatedAt'),
            'endCreatedAt' => RequestHelper::getNumericParameter('endCreatedAt')
        ];
    }
}
