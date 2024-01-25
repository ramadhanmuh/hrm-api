<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class GetUserRequest
{
    public $input;
    private $availableSelect = [
        'id', 'email', 'name', 'role', 'status',
        'createdAt', 'updatedAt'
    ],  $availableStatus = ['0', '1'],
        $availableRole = ['Pemilik', 'Pengelola', 'Karyawan'],
        $availableDirection = ['asc', 'ASC', 'desc', 'DESC'],
        $defaultDirection = 'ASC',
        $defaultOrder = 'name';

    function __construct() {
        $this->input = [
            'select' => RequestHelper::getSelectParameter($this->availableSelect),
            'offset' => RequestHelper::getOffsetParameter('offset'),
            'limit' => RequestHelper::getLimitParameter('limit'),
            'status' => RequestHelper::getStringParameterWithAvailableValue('status', $this->availableStatus),
            'role' => RequestHelper::getStringParameterWithAvailableValue('role', $this->availableRole),
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
