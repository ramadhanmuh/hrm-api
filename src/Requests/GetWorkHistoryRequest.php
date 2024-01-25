<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class GetWorkHistoryRequest
{
    public $input;
    private $availableSelect = [
        'id', 'employeeId', 'dateOfJoin', 'createdAt',
        'updatedAt'
    ], $availableDirection = [
        'asc', 'ASC', 'desc', 'DESC'
    ],  $availableOrder = [
        'id', 'employeeId', 'dateOfJoin', 'createdAt',
        'updatedAt', 'employeeName',
        'employeeRegistrationNumber', 'employeeEmail'
    ],  $defaultOrder = 'dateOfJoin',
        $defaultDirection = 'ASC';

    function __construct() {
        $this->input = [
            'select' => RequestHelper::getSelectParameter($this->availableSelect),
            'offset' => RequestHelper::getOffsetParameter(),
            'limit' => RequestHelper::getLimitParameter(),
            'keyword' => RequestHelper::getStringParameter('keyword'),
            'id' => RequestHelper::getArrayParameter('id'),
            'employeeId' => RequestHelper::getArrayParameter('employeeId'),
            'startCreatedAt' => RequestHelper::getNumericParameter('startCreatedAt'),
            'endCreatedAt' => RequestHelper::getNumericParameter('endCreatedAt'),
            'startDateOfJoin' => RequestHelper::getNumericParameter('startDateOfJoin'),
            'endDateOfJoin' => RequestHelper::getNumericParameter('endDateOfJoin'),
            'orderBy' => RequestHelper::getStringParameterWithAvailableValue(
                'orderBy', $this->availableOrder, $this->defaultOrder
            ),
            'orderDirection' => RequestHelper::getStringParameterWithAvailableValue(
                'orderDirection', $this->availableDirection, $this->defaultDirection
            ),
        ];
    }
}
