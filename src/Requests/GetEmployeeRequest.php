<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class GetEmployeeRequest
{
    public $input;
    private $availableSelect = [
        'id', 'registrationNumber', 'designationId', 'name',
        'phone', 'dateOfBirth', 'gender', 'address', 'dateOfJoin',
        'bankAccountHolderName','bankAccountNumber', 'bankName',
        'createdAt', 'updatedAt'
    ],  $availableDirection = ['asc', 'ASC', 'desc', 'DESC'],
        $defaultDirection = 'ASC',
        $defaultOrder = 'name',
        $availableStatus = ['0', '1'],
        $availableGender = ['Pria', 'Wanita'];

    function __construct() {
        $this->input = [
            'select' => RequestHelper::getSelectParameter($this->availableSelect),
            'offset' => RequestHelper::getOffsetParameter(),
            'limit' => RequestHelper::getLimitParameter(),
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
            'orderBy' => RequestHelper::getStringParameterWithAvailableValue(
                'orderBy', $this->availableSelect, $this->defaultOrder
            ),
            'orderDirection' => RequestHelper::getStringParameterWithAvailableValue(
                'orderDirection', $this->availableDirection, $this->defaultDirection
            ),
        ];
    }
}
