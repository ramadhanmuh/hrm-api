<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;

class CountUserRequest
{
    public $input;
    private $availableStatus = ['0', '1'],
            $availableRole = ['Pemilik', 'Pengelola', 'Karyawan'];

    function __construct() {
        $this->input = [
            'status' => RequestHelper::getStringParameterWithAvailableValue('status', $this->availableStatus),
            'role' => RequestHelper::getStringParameterWithAvailableValue('role', $this->availableRole),
            'keyword' => RequestHelper::getStringParameter('keyword'),
            'id' => RequestHelper::getArrayParameter('id'),
            'startCreatedAt' => RequestHelper::getNumericParameter('startCreatedAt'),
            'endCreatedAt' => RequestHelper::getNumericParameter('endCreatedAt')
        ];
    }
}
