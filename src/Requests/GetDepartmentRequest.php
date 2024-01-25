<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class GetDepartmentRequest
{
    public $input;
    private $availableSelect = [
        'id', 'branchId', 'name',
        'createdAt', 'updatedAt'
    ],  $availableDirection = [
        'asc', 'ASC', 'desc', 'DESC'
    ],  $defaultOrder = 'name',
        $defaultDirection = 'ASC';

    function __construct() {
        $this->input = [
            'select' => RequestHelper::getSelectParameter($this->availableSelect),
            'offset' => RequestHelper::getOffsetParameter(),
            'limit' => RequestHelper::getLimitParameter(),
            'keyword' => RequestHelper::getStringParameter('keyword'),
            'id' => RequestHelper::getArrayParameter('id'),
            'branchId' => RequestHelper::getArrayParameter('branchId'),
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
