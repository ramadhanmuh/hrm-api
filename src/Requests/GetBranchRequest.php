<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class GetBranchRequest
{
    public $input;
    private $availableSelect = [
        'id', 'name', 'createdAt', 'updatedAt'
    ], $availableDirection = ['asc', 'ASC', 'desc', 'DESC'],
        $defaultDirection = 'ASC',
        $defaultOrder = 'name';

    function __construct() {
        $this->input = [
            'select' => RequestHelper::getSelectParameter($this->availableSelect),
            'offset' => RequestHelper::getOffsetParameter(),
            'limit' => RequestHelper::getLimitParameter(),
            'keyword' => RequestHelper::getStringParameter('keyword'),
            'id' => RequestHelper::getArrayParameter('id'),
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
