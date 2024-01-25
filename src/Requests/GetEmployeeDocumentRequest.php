<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class GetEmployeeDocumentRequest
{
    public $input;
    private $availableSelect = [
        'id', 'employeeId', 'documentId', 'file', 'createdAt', 'updatedAt'
    ],  $availableDirection = ['asc', 'ASC', 'desc', 'DESC'],
        $defaultOrder = 'createdAt',
        $defaultDirection = 'ASC';

    function __construct() {
        $this->input = [
            'select' => RequestHelper::getSelectParameter($this->availableSelect),
            'offset' => RequestHelper::getOffsetParameter(),
            'limit' => RequestHelper::getLimitParameter(),
            'keyword' => RequestHelper::getStringParameter('keyword'),
            'id' => RequestHelper::getArrayParameter('id'),
            'employeeId' => RequestHelper::getArrayParameter('employeeId'),
            'documentId' => RequestHelper::getArrayParameter('documentId'),
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
