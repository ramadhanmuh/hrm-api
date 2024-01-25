<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class GetDocumentRequest
{
    public $input;
    private $availableSelect = [
        'id', 'status', 'name',
        'createdAt', 'updatedAt'
    ], $availableDirection = [
        'asc', 'ASC', 'desc', 'DESC'
    ],  $availableStatus = [
        '0', '1'
    ],  $defaultOrder = 'name',
        $defaultDirection = 'ASC';

    function __construct() {
        $this->input = [
            'select' => RequestHelper::getSelectParameter($this->availableSelect),
            'offset' => RequestHelper::getOffsetParameter(),
            'limit' => RequestHelper::getLimitParameter(),
            'keyword' => RequestHelper::getStringParameter('keyword'),
            'id' => RequestHelper::getArrayParameter('id'),
            'status' => RequestHelper::getStringParameterWithAvailableValue(
                'status', $this->availableStatus
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
