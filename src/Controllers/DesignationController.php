<?php

namespace Src\Controllers;

use Src\Helpers\RequestHelper;
use Src\Helpers\ResponseHelper;
use Src\Helpers\TimeHelper;
use Src\Models\Designation;
use Src\Requests\CountDesignationRequest;
use Src\Requests\GetDesignationRequest;
use Src\Requests\StoreDesignationRequest;
use Src\Requests\UpdateDesignationRequest;

class DesignationController
{
    function list() {
        $request = new GetDesignationRequest;
        
        $data['rules'] = $request->input;

        $data['list'] = Designation::get($data['rules']);

        return ResponseHelper::createSuccessGetData($data);        
    }

    function count() {
        $request = new CountDesignationRequest;
        
        $data['rules'] = $request->input; 

        $data['total'] = Designation::count($data['rules']);

        return ResponseHelper::createSuccessGetData($data);        
    }

    function create() {
        $request = new StoreDesignationRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest(
                $request->validation['messages']
            );
        }

        $request->input['createdAt'] = TimeHelper::createTimeNow();
        $request->input['updatedAt'] = $request->input['createdAt'];

        Designation::insertOne(Designation::$table, $request->input);

        return ResponseHelper::createSuccessCreateData($request->input);
    }

    function getOne() {
        $data = Designation::getOneByColumn(
            Designation::$table, Designation::$columns,
            'id', RequestHelper::getSegmentContent(2)
        );

        return $data === null
                ? ResponseHelper::createNotFound()
                : ResponseHelper::createSuccessGetData($data);
    }

    function update() {
        $id = RequestHelper::getSegmentContent(2);

        $data = Designation::getOneByColumn(
            Designation::$table, Designation::$columns,
            'id', $id
        );

        if ($data === null) {
            return ResponseHelper::createNotFound();
        }

        $request = new UpdateDesignationRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest(
                $request->validation['messages']
            );
        }

        $request->input['updatedAt'] = TimeHelper::createTimeNow();

        Designation::updateOne(Designation::$table, $request->input, $id);

        return ResponseHelper::createSuccessUpdateData($request->input);
    }

    function delete() {
        $id = RequestHelper::getSegmentContent(2);

        $data = Designation::getOneByColumn(
            Designation::$table, 'name', 'id', $id
        );

        if ($data === null) {
            return ResponseHelper::createNotFound();
        }

        Designation::deleteOne(Designation::$table, $id);

        return ResponseHelper::createSuccessDeleteData();
    }
}
