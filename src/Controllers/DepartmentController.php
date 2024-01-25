<?php

namespace Src\Controllers;

use Src\Helpers\RequestHelper;
use Src\Helpers\ResponseHelper;
use Src\Helpers\TimeHelper;
use Src\Models\Department;
use Src\Requests\CountDepartmentRequest;
use Src\Requests\GetDepartmentRequest;
use Src\Requests\StoreDepartmentRequest;
use Src\Requests\UpdateDepartmentRequest;

class DepartmentController
{
    function list() {
        $request = new GetDepartmentRequest;
        
        $data['rules'] = $request->input; 

        $data['list'] = Department::get($data['rules']);

        return ResponseHelper::createSuccessGetData($data);        
    }

    function count() {
        $request = new CountDepartmentRequest;
        
        $data['rules'] = $request->input;

        $data['total'] = Department::count($data['rules']);

        return ResponseHelper::createSuccessGetData($data);        
    }

    function create() {
        $request = new StoreDepartmentRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest(
                $request->validation['messages']
            );
        }

        $request->input['createdAt'] = TimeHelper::createTimeNow();

        $request->input['updatedAt'] = $request->input['createdAt'];

        Department::insertOne(Department::$table, $request->input);

        return ResponseHelper::createSuccessCreateData($request->input);
    }

    function getOne() {
        $data = Department::getOneByColumn(
            Department::$table, Department::$columns, 'id',
            RequestHelper::getSegmentContent(2)
        );

        return $data === null
                ? ResponseHelper::createNotFound()
                : ResponseHelper::createSuccessGetData($data);
    }

    function update() {
        $id = RequestHelper::getSegmentContent(2);

        if (
            Department::getOneByColumn(
                Department::$table, 'name', 'id', $id
            ) === null
        ) {
            return ResponseHelper::createNotFound();
        }

        $request = new UpdateDepartmentRequest();

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest(
                $request->validation['messages']
            );
        }

        Department::updateOne(Department::$table, $request->input, $id);

        return ResponseHelper::createSuccessUpdateData($request->input);
    }

    function delete() {
        $id = RequestHelper::getSegmentContent(2);

        if (
            Department::getOneByColumn(
                Department::$table, 'name', 'id', $id
            ) === null
        ) {
            return ResponseHelper::createNotFound();
        }

        Department::deleteOne(Department::$table, $id);

        return ResponseHelper::createSuccessDeleteData();
    }
}
