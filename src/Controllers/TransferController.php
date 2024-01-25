<?php

namespace Src\Controllers;

use Src\Helpers\RequestHelper;
use Src\Helpers\ResponseHelper;
use Src\Models\Transfer;
use Src\Requests\CountTransferRequest;
use Src\Requests\GetTransferRequest;
use Src\Requests\StoreTransferRequest;
use Src\Requests\UpdateTransferRequest;

class TransferController
{
    function list() {
        $request = new GetTransferRequest;
        
        $data['rules'] = $request->input;

        $data['list'] = Transfer::get($data['rules']);

        return ResponseHelper::createSuccessGetData($data);        
    }

    function count() {
        $request = new CountTransferRequest;
        
        $data['rules'] = $request->input;

        $data['total'] = Transfer::count($data['rules']);

        return ResponseHelper::createSuccessGetData($data);        
    }

    function create() {
        $request = new StoreTransferRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest(
                $request->validation['messages']
            );
        }

        Transfer::insertOne(Transfer::$table, $request->input);

        return ResponseHelper::createSuccessCreateData($request->input);
    }

    function getOne() {
        $data = Transfer::getOneByColumn(
            Transfer::$table, Transfer::$columns,
            'id', RequestHelper::getSegmentContent(2)
        );

        return $data === null
                ? ResponseHelper::createNotFound()
                : ResponseHelper::createSuccessGetData($data);
    }

    function update() {
        $id = RequestHelper::getSegmentContent(2);

        $data = Transfer::getOneByColumn(
            Transfer::$table, 'id',
            'id', $id
        );

        if ($data === null) {
            return ResponseHelper::createNotFound();
        }

        $request = new UpdateTransferRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest(
                $request->validation['messages']
            );
        }

        Transfer::updateOne(Transfer::$table, $request->input, $id);

        return ResponseHelper::createSuccessUpdateData($request->input);
    }

    function delete() {
        $id = RequestHelper::getSegmentContent(2);

        $data = Transfer::getOneByColumn(
            Transfer::$table, 'id',
            'id', $id
        );

        if ($data === null) {
            return ResponseHelper::createNotFound();
        }

        Transfer::deleteOne(Transfer::$table, $id);

        return ResponseHelper::createSuccessDeleteData();
    }
}
