<?php

namespace Src\Controllers;

use Src\Helpers\RequestHelper;
use Src\Helpers\ResponseHelper;
use Src\Helpers\TimeHelper;
use Src\Models\TerminationType;
use Src\Requests\CountTerminationTypeRequest;
use Src\Requests\GetTerminationTypeRequest;
use Src\Requests\StoreTerminationTypeRequest;
use Src\Requests\UpdateTerminationTypeRequest;

class TerminationTypeController
{
    function list() {
        $request = new GetTerminationTypeRequest;
        
        $data['rules'] = $request->input;

        $data['list'] = TerminationType::get($data['rules']);

        return ResponseHelper::createSuccessGetData($data);        
    }

    function count() {
        $request = new CountTerminationTypeRequest;
        
        $data['rules'] = $request->input;

        $data['total'] = TerminationType::count($data['rules']);

        return ResponseHelper::createSuccessGetData($data);        
    }

    function create() {
        $request = new StoreTerminationTypeRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest(
                $request->validation['messages']
            );
        }

        $request->input['createdAt'] = TimeHelper::createTimeNow();
        $request->input['updatedAt'] = $request->input['createdAt'];

        TerminationType::insertOne(TerminationType::$table, $request->input);

        return ResponseHelper::createSuccessCreateData($request->input);
    }

    function getOne() {
        $data = TerminationType::getOneByColumn(
            TerminationType::$table, TerminationType::$columns,
            'id', RequestHelper::getSegmentContent(2)
        );

        return $data === null
                ? ResponseHelper::createNotFound()
                : ResponseHelper::createSuccessGetData($data);
    }

    function update() {
        $id = RequestHelper::getSegmentContent(2);

        $data = TerminationType::getOneByColumn(
            TerminationType::$table, 'name', 'id', $id
        );

        if ($data === null) {
            return ResponseHelper::createNotFound();
        }

        $request = new UpdateTerminationTypeRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest(
                $request->validation['messages']
            );
        }
        
        $request->input['updatedAt'] = TimeHelper::createTimeNow();

        TerminationType::updateOne(TerminationType::$table, $request->input, $id);

        return ResponseHelper::createSuccessUpdateData($request->input);
    }

    function delete() {
        $id = RequestHelper::getSegmentContent(2);

        $data = TerminationType::getOneByColumn(
            TerminationType::$table, 'name', 'id', $id
        );

        if ($data === null) {
            return ResponseHelper::createNotFound();
        }

        TerminationType::deleteOne(TerminationType::$table, $id);

        return ResponseHelper::createSuccessDeleteData();
    }
}
