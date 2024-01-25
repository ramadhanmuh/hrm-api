<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class GetTerminationRequest
{
    public $input;
    private $availableSelect = [
        'id', 'employeeId', 'terminationTypeId', 'noticeDate',
        'date', 'description', 'createdAt', 'updatedAt'
    ], $availableDirection = [
        'asc', 'ASC', 'desc', 'DESC'
    ],  $availableOrder = [
        'id', 'employeeId', 'noticeDate', 'date',
        'description', 'createdAt', 'updatedAt',
        'employeeName', 'employeeRegistrationNumber',
        'employeeEmail', 'terminationTypeName'
    ],  $defaultOrder = 'date', $defaultDirection = 'ASC';

    function __construct() {
        $this->input = [
            'select' => RequestHelper::getSelectParameter($this->availableSelect),
            'offset' => RequestHelper::getOffsetParameter(),
            'limit' => RequestHelper::getLimitParameter(),
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
            'orderBy' => RequestHelper::getStringParameterWithAvailableValue(
                'orderBy', $this->availableOrder, $this->defaultOrder
            ),
            'orderDirection' => RequestHelper::getStringParameterWithAvailableValue(
                'orderDirection', $this->availableDirection, $this->defaultDirection
            ),
        ];
    }
}
