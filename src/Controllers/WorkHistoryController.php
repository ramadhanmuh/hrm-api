<?php

namespace Src\Controllers;

use Src\Helpers\RequestHelper;
use Src\Helpers\ResponseHelper;
use Src\Models\WorkHistory;
use Src\Requests\CountWorkHistoryRequest;
use Src\Requests\GetWorkHistoryRequest;
use Src\Requests\StoreWorkHistoryRequest;
use Src\Requests\UpdateWorkHistoryRequest;

class WorkHistoryController
{
    function list() {
        $request = new GetWorkHistoryRequest;
        
        $data['rules'] = $request->input;

        $data['list'] = WorkHistory::get($data['rules']);

        return ResponseHelper::createSuccessGetData($data);        
    }

    function count() {
        $request = new CountWorkHistoryRequest;
        
        $data['rules'] = $request->input;

        $data['total'] = WorkHistory::count($data['rules']);

        return ResponseHelper::createSuccessGetData($data);        
    }

    function create() {
        $request = new StoreWorkHistoryRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest(
                $request->validation['messages']
            );
        }

        WorkHistory::insertOne(WorkHistory::$table, $request->input);

        return ResponseHelper::createSuccessCreateData($request->input);
    }

    function getOne() {
        $data = WorkHistory::getOneByColumn(
            WorkHistory::$table, WorkHistory::$columns,
            'id', RequestHelper::getSegmentContent(2)
        );

        return $data === null
                ? ResponseHelper::createNotFound()
                : ResponseHelper::createSuccessGetData($data);
    }

    function update() {
        $id = RequestHelper::getSegmentContent(2);

        if  (
                WorkHistory::getOneByColumn(
                    WorkHistory::$table, 'id', 'id', $id
                ) === null
            ) {
            return ResponseHelper::createNotFound();
        }

        $request = new UpdateWorkHistoryRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest(
                $request->validation['messages']
            );
        }

        WorkHistory::updateOne(WorkHistory::$table, $request->input, $id);

        return ResponseHelper::createSuccessUpdateData($request->input);
    }

    function delete() {
        $id = RequestHelper::getSegmentContent(2);

        if  (
            WorkHistory::getOneByColumn(
                WorkHistory::$table, 'id', 'id', $id
            ) === null
        ) {
        return ResponseHelper::createNotFound();
    }

        WorkHistory::deleteOne(WorkHistory::$table, $id);

        return ResponseHelper::createSuccessDeleteData();
    }
}
