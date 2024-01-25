<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class CountEmployeeRequest
{
    public $input;
    private $availableStatus = ['0', '1'],
            $availableGender = ['Pria', 'Wanita'];

    function __construct() {
        $this->input = [
            'keyword' => RequestHelper::getStringParameter('keyword'),
            'id' => RequestHelper::getArrayParameter('id'),
            'designationId' => RequestHelper::getArrayParameter('designationId'),
            'status' => RequestHelper::getStringParameterWithAvailableValue(
                'status', $this->availableStatus
            ),
            'gender' => RequestHelper::getStringParameterWithAvailableValue(
                'gender', $this->availableGender
            ),
            'startCreatedAt' => RequestHelper::getNumericParameter('startCreatedAt'),
            'endCreatedAt' => RequestHelper::getNumericParameter('endCreatedAt'),
        ];
    }
}
