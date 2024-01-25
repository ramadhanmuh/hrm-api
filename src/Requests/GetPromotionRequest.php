<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class GetPromotionRequest
{
    public $input;
    private $availableSelect = [
        'id', 'employeeId', 'designationId', 'title',
        'date', 'description', 'createdAt', 'updatedAt'
    ], $availableDirection = [
        'asc', 'ASC', 'desc', 'DESC'
    ],  $availableOrder = [
        'id', 'employeeId', 'designationId', 'date',
        'description', 'createdAt', 'updatedAt',
        'employeeName', 'employeeRegistrationNumber',
        'employeeEmail', 'designationName', 'title'
    ],  $defaultOrder = 'date', $defaultDirection = 'ASC';

    function __construct() {
        $this->input = [
            'select' => RequestHelper::getSelectParameter($this->availableSelect),
            'offset' => RequestHelper::getOffsetParameter(),
            'limit' => RequestHelper::getLimitParameter(),
            'keyword' => RequestHelper::getStringParameter('keyword'),
            'id' => RequestHelper::getArrayParameter('id'),
            'employeeId' => RequestHelper::getArrayParameter('employeeId'),
            'designationId' => RequestHelper::getArrayParameter('designationId'),
            'startCreatedAt' => RequestHelper::getNumericParameter('startCreatedAt'),
            'endCreatedAt' => RequestHelper::getNumericParameter('endCreatedAt'),
            'startDate' => RequestHelper::getNumericParameter('startDate'),
            'endDate' => RequestHelper::getNumericParameter('endDate'),
            'orderBy' => RequestHelper::getStringParameterWithAvailableValue(
                'orderBy', $this->availableOrder, $this->defaultOrder
            ),
            'orderDirection' => RequestHelper::getStringParameterWithAvailableValue(
                'orderDirection', $this->availableDirection, $this->defaultDirection
            ),
        ];
    }
}
