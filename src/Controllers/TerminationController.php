<?php

namespace Src\Controllers;

use Src\Helpers\RequestHelper;
use Src\Helpers\ResponseHelper;
use Src\Models\Termination;
use Src\Requests\CountTerminationRequest;
use Src\Requests\GetTerminationRequest;
use Src\Requests\StoreTerminationRequest;
use Src\Requests\UpdateTerminationRequest;

class TerminationController
{
    function list() {
        $request = new GetTerminationRequest;
        
        $data['rules'] = $request->input;

        $data['list'] = Termination::get($data['rules']);

        return ResponseHelper::createSuccessGetData($data);        
    }

    function count() {
        $request = new CountTerminationRequest;
        
        $data['rules'] = $request->input;

        $data['total'] = Termination::count($data['rules']);

        return ResponseHelper::createSuccessGetData($data);        
    }

    function create() {
        $request = new StoreTerminationRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest(
                $request->validation['messages']
            );
        }

        Termination::insertOne(Termination::$table, $request->input);

        return ResponseHelper::createSuccessCreateData($request->input);
    }

    function getOne() {
        $data = Termination::getOneByColumn(
            Termination::$table, Termination::$columns,
            'id', RequestHelper::getSegmentContent(2)
        );

        return $data === null
                ? ResponseHelper::createNotFound()
                : ResponseHelper::createSuccessGetData($data);
    }

    function update() {
        $id = RequestHelper::getSegmentContent(2);

        $data = Termination::getOneByColumn(
            Termination::$table, 'id',
            'id', $id
        );

        if ($data === null) {
            return ResponseHelper::createNotFound();
        }

        $request = new UpdateTerminationRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest(
                $request->validation['messages']
            );
        }

        Termination::updateOne(Termination::$table, $request->input, $id);

        return ResponseHelper::createSuccessUpdateData($request->input);
    }

    function delete() {
        $id = RequestHelper::getSegmentContent(2);

        $data = Termination::getOneByColumn(
            Termination::$table, 'id',
            'id', $id
        );

        if ($data === null) {
            return ResponseHelper::createNotFound();
        }

        Termination::deleteOne(Termination::$table, $id);

        return ResponseHelper::createSuccessDeleteData();
    }
}
