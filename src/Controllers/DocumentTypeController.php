<?php

namespace Src\Controllers;

use Src\Configurations\AvailableDocumentType;
use Src\Helpers\ResponseHelper;

class DocumentTypeController
{
    function list() {
        return ResponseHelper::createSuccessGetData(
            AvailableDocumentType::get()
        );
    }
}
