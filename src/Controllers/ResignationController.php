<?php

namespace Src\Controllers;

use Src\Helpers\RequestHelper;
use Src\Helpers\ResponseHelper;
use Src\Models\Resignation;
use Src\Requests\CountResignationRequest;
use Src\Requests\GetResignationRequest;
use Src\Requests\StoreResignationRequest;
use Src\Requests\UpdateResignationRequest;

class ResignationController
{
    function list() {
        $request = new GetResignationRequest;
        
        $data['rules'] = $request->input;

        $data['list'] = Resignation::get($data['rules']);

        return ResponseHelper::createSuccessGetData($data);        
    }

    function count() {
        $request = new CountResignationRequest;
        
        $data['rules'] = $request->input;

        $data['total'] = Resignation::count($data['rules']);

        return ResponseHelper::createSuccessGetData($data);        
    }

    function create() {
        $request = new StoreResignationRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest(
                $request->validation['messages']
            );
        }

        Resignation::insertOne(Resignation::$table, $request->input);

        return ResponseHelper::createSuccessCreateData($request->input);
    }

    function getOne() {
        $data = Resignation::getOneByColumn(
            Resignation::$table, Resignation::$columns,
            'id', RequestHelper::getSegmentContent(2)
        );

        return $data === null
                ? ResponseHelper::createNotFound()
                : ResponseHelper::createSuccessGetData($data);
    }

    function update() {
        $id = RequestHelper::getSegmentContent(2);

        if  (
                Resignation::getOneByColumn(
                    Resignation::$table, 'id', 'id', $id
                ) === null
            ) {
            return ResponseHelper::createNotFound();
        }

        $request = new UpdateResignationRequest();

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest(
                $request->validation['messages']
            );
        }

        Resignation::updateOne(Resignation::$table, $request->input, $id);

        return ResponseHelper::createSuccessUpdateData($request->input);
    }

    function delete() {
        $id = RequestHelper::getSegmentContent(2);

        if  (
                Resignation::getOneByColumn(
                    Resignation::$table, 'id', 'id', $id
                ) === null
            ) {
            return ResponseHelper::createNotFound();
        }
        
        Resignation::deleteOne(Resignation::$table, $id);

        return ResponseHelper::createSuccessDeleteData();
    }
}
