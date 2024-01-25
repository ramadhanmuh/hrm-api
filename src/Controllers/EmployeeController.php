<?php

namespace Src\Controllers;

use Src\Configurations\Environment;
use Src\Helpers\RequestHelper;
use Src\Helpers\ResponseHelper;
use Src\Helpers\StringHelper;
use Src\Models\Employee;
use Src\Requests\CountEmployeeRequest;
use Src\Requests\GetEmployeeRequest;
use Src\Requests\StoreEmployeeRequest;
use Src\Requests\UpdateEmployeeRequest;

class EmployeeController
{
    function list() {
        $request = new GetEmployeeRequest;

        $data['rules'] = $request->input;

        $data['list'] = Employee::get($data['rules']);

        return ResponseHelper::createSuccessGetData($data);
    }

    function count() {
        $request = new CountEmployeeRequest;

        $data['rules'] = $request->input;

        $data['total'] = Employee::count($data['rules']);

        return ResponseHelper::createSuccessGetData($data);
    }

    function getOne() {
        $data = Employee::getOneByColumn(
            Employee::$table, Employee::$columns,
            'id', RequestHelper::getSegmentContent(2)
        );

        return $data === null
                ? ResponseHelper::createNotFound()
                : ResponseHelper::createSuccessGetData($data);
    }

    function create() {
        $request = new StoreEmployeeRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest($request->validation['messages']);
        }

        if (!empty($request->files)) {
            foreach ($request->files as $fileKey => $fileValue) {
                $folderPath = 'src/Storage/Files/Employee/'
                                . $request->input['id'];
    
                $pathToCreate = './' . $folderPath;
    
                if (!file_exists($pathToCreate)) {
                    if (!mkdir($pathToCreate)) {
                        return ResponseHelper::createInternalServerError();
                    }
                }
    
                $fileName = StringHelper::hash(microtime()) . '.'
                                . $fileValue['extension'];
    
                if (!file_put_contents($pathToCreate . '/' . $fileName, $fileValue['file'])) {
                    return ResponseHelper::createInternalServerError();
                }
    
                $request->input['employeeDocuments'][$fileKey]['file'] =
                    $folderPath . '/' . $fileName;
            }
        }

        if ($request->input['employeeDocuments'] === null) {
            unset($request->input['employeeDocuments']);

            Employee::insertOne(Employee::$table, $request->input);
        } else {
            Employee::insertWithDocuments($request->input);

            foreach ($request->input['employeeDocuments'] as $key => $value) {
                $request->input['employeeDocuments'][$key]['file'] =
                    Environment::$value['baseURL']
                    . 'employee-documents/'
                    . $value['id']
                    . '/open';
            }
        }

        return ResponseHelper::createSuccessCreateData($request->input);
    }

    function update() {
        $id = RequestHelper::getSegmentContent(2);

        $data = Employee::getOneByColumn(
            Employee::$table, 'id',
            'id', RequestHelper::getSegmentContent(2)
        );

        if ($data === null) {
            return ResponseHelper::createNotFound();
        }

        $request = new UpdateEmployeeRequest($id);

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest($request->validation['messages']);
        }

        Employee::updateOne(Employee::$table, $request->input, $id);

        return ResponseHelper::createSuccessUpdateData($request->input);
    }

    function delete() {
        $id = RequestHelper::getSegmentContent(2);

        $data = Employee::getOneByColumn(
            Employee::$table, 'id',
            'id', RequestHelper::getSegmentContent(2)
        );

        if ($data === null) {
            return ResponseHelper::createNotFound();
        }

        Employee::deleteOne(Employee::$table, $id);

        return ResponseHelper::createSuccessDeleteData();
    }
}
