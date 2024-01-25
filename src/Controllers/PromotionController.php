<?php

namespace Src\Controllers;

use Src\Helpers\RequestHelper;
use Src\Helpers\ResponseHelper;
use Src\Models\Promotion;
use Src\Requests\CountPromotionRequest;
use Src\Requests\GetPromotionRequest;
use Src\Requests\StorePromotionRequest;
use Src\Requests\UpdatePromotionRequest;

class PromotionController
{
    function list() {
        $request = new GetPromotionRequest;
        
        $data['rules'] = $request->input;

        $data['list'] = Promotion::get($data['rules']);

        return ResponseHelper::createSuccessGetData($data);        
    }

    function count() {
        $request = new CountPromotionRequest;
        
        $data['rules'] = $request->input;

        $data['total'] = Promotion::count($data['rules']);

        return ResponseHelper::createSuccessGetData($data);        
    }

    function create() {
        $request = new StorePromotionRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest(
                $request->validation['messages']
            );
        }

        Promotion::insertOne(Promotion::$table, $request->input);

        return ResponseHelper::createSuccessCreateData($request->input);
    }

    function getOne() {
        $data = Promotion::getOneByColumn(
            Promotion::$table, Promotion::$columns,
            'id', RequestHelper::getSegmentContent(2)
        );

        return $data === null
                ? ResponseHelper::createNotFound()
                : ResponseHelper::createSuccessGetData($data);
    }

    function update() {
        $id = RequestHelper::getSegmentContent(2);

        if (Promotion::getOneByColumn(Promotion::$table, 'id', 'id', $id) === null) {
            return ResponseHelper::createNotFound();
        }

        $request = new UpdatePromotionRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest(
                $request->validation['messages']
            );
        }

        Promotion::updateOne(Promotion::$table, $request->input, $id);

        return ResponseHelper::createSuccessUpdateData($request->input);
    }

    function delete() {
        $id = RequestHelper::getSegmentContent(2);

        if (Promotion::getOneByColumn(Promotion::$table, 'id', 'id', $id) === null) {
            return ResponseHelper::createNotFound();
        }

        Promotion::deleteOne(Promotion::$table, $id);

        return ResponseHelper::createSuccessDeleteData();
    }
}
