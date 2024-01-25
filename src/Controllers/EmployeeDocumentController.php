<?php

namespace Src\Controllers;

use Src\Configurations\Environment;
use Src\Helpers\RequestHelper;
use Src\Helpers\ResponseHelper;
use Src\Helpers\StringHelper;
use Src\Models\EmployeeDocument;
use Src\Requests\CountEmployeeDocumentRequest;
use Src\Requests\GetEmployeeDocumentRequest;
use Src\Requests\StoreEmployeeDocumentRequest;
use Src\Requests\UpdateEmployeeDocumentRequest;

class EmployeeDocumentController
{
    function list() {
        $request = new GetEmployeeDocumentRequest;

        $data['rules'] = $request->input;

        $data['list'] = EmployeeDocument::get($data['rules']);

        return ResponseHelper::createSuccessGetData($data);
    }

    function count() {
        $request = new CountEmployeeDocumentRequest;

        $data['rules'] = $request->input;

        $data['total'] = EmployeeDocument::count($data['rules']);

        return ResponseHelper::createSuccessGetData($data);
    }

    function getOne() {
        $data = EmployeeDocument::getOneByColumn(
            EmployeeDocument::$table, EmployeeDocument::getColumns(),
            'id', RequestHelper::getSegmentContent(2)
        );

        return $data === null
                ? ResponseHelper::createNotFound()
                : ResponseHelper::createSuccessGetData($data);
    }

    function open() {
        $data = EmployeeDocument::getWithDocumentById(
            RequestHelper::getSegmentContent(2)
        );

        return $data === null
                ? ResponseHelper::createNotFound()
                : ResponseHelper::createFileResponse(
                    $data['file'], $data['mime'], $data['name']
                );
    }

    function create() {
        $request = new StoreEmployeeDocumentRequest();

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest(
                $request->validation['messages']
            );
        }

        $folderPath = 'src/Storage/Files/Employee/'
                            . $request->input['employeeId'];

        $pathToCreate = './' . $folderPath;

        if (!file_exists($pathToCreate)) {
            if (!mkdir($pathToCreate)) {
                return ResponseHelper::createInternalServerError();
            }
        }

        $fileName = StringHelper::hash(microtime()) . '.'
                        . $request->fileExtension;

        if (!file_put_contents($pathToCreate . '/' . $fileName, $request->fileValue)) {
            return ResponseHelper::createInternalServerError();
        }

        $request->input['file'] = $folderPath . '/' . $fileName;

        EmployeeDocument::insertOne(EmployeeDocument::$table, $request->input);

        $request->input['file'] = Environment::$value['baseURL']
                                    . '/' . RequestHelper::getSegmentContent(0)
                                    . '/employee-documents/' . $request->input['id']
                                    . '/open';

        return ResponseHelper::createSuccessCreateData($request->input);
    }

    function update() {
        $id = RequestHelper::getSegmentContent(2);

        $data = EmployeeDocument::getOneByColumn(
            EmployeeDocument::$table, 'file', 'id', $id
        );

        if ($data === null) {
            return ResponseHelper::createNotFound();
        }

        $request = new UpdateEmployeeDocumentRequest($id);

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest($request->validation['messages']);
        }

        if ($request->fileValue !== null) {
            $folderPath = 'src/Storage/Files/Employee/'
                            . $request->input['employeeId'];

            $pathToCreate = './' . $folderPath;

            if (!file_exists($pathToCreate)) {
                if (!mkdir($pathToCreate)) {
                    return ResponseHelper::createInternalServerError();
                }
            }

            $fileName = StringHelper::hash(microtime()) . '.'
                            . $request->fileExtension;

            if (!file_put_contents($pathToCreate . '/' . $fileName, $request->fileValue)) {
                return ResponseHelper::createInternalServerError();
            }

            $request->input['file'] = $folderPath . '/' . $fileName;
        }

        EmployeeDocument::updateOne(
            EmployeeDocument::$table, $request->input, $id
        );

        $request->input['file'] = Environment::$value['baseURL']
                                    . '/' . RequestHelper::getSegmentContent(0)
                                    . '/employee-documents/' . $id . '/open';

        return ResponseHelper::createSuccessUpdateData($request->input);
    }

    function delete() {
        $id = RequestHelper::getSegmentContent(2);

        if (EmployeeDocument::getNotRequiredById($id) === null) {
            return ResponseHelper::createNotFound();
        }

        EmployeeDocument::deleteOne(EmployeeDocument::$table, $id);

        return ResponseHelper::createSuccessDeleteData();
    }
}
