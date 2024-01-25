<?php

namespace Src\Controllers;

use Src\Helpers\RequestHelper;
use Src\Helpers\ResponseHelper;
use Src\Helpers\TimeHelper;
use Src\Models\Branch;
use Src\Requests\CountBranchRequest;
use Src\Requests\GetBranchRequest;
use Src\Requests\StoreBranchRequest;
use Src\Requests\UpdateBranchRequest;

class BranchController
{
    function list() {
        $request = new GetBranchRequest;

        $data['rules'] = $request->input;

        $data['list'] = Branch::get($data['rules']);

        return ResponseHelper::createSuccessGetData($data);
    }

    function count() {
        $request = new CountBranchRequest;

        $data['rules'] = $request->input;

        $data['total'] = Branch::count($data['rules']);

        return ResponseHelper::createSuccessGetData($data);
    }

    function getOne() {
        $data = Branch::getOneByColumn(
            Branch::$table, Branch::$columns, 'id', RequestHelper::getSegmentContent(2)
        );

        return $data === null
                ? ResponseHelper::createNotFound()
                : ResponseHelper::createSuccessGetData($data);
    }

    function create() {
        $request = new StoreBranchRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest($request->validation['messages']);
        }

        $request->input['createdAt'] = TimeHelper::createTimeNow();
        $request->input['updatedAt'] = $request->input['createdAt'];

        Branch::insertOne(Branch::$table, $request->input);

        return ResponseHelper::createSuccessCreateData($request->input);
    }

    function update() {
        $id = RequestHelper::getSegmentContent(2);

        if (
            Branch::getOneByColumn(
                Branch::$table, 'name', 'id', $id
            ) === null
        ) {
            return ResponseHelper::createNotFound(); 
        }

        $request = new UpdateBranchRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest($request->validation['messages']);
        }

        $request->input['updatedAt'] = TimeHelper::createTimeNow();

        Branch::updateOne(Branch::$table, $request->input, $id);

        return ResponseHelper::createSuccessUpdateData($request->input);
    }

    function delete() {
        $id = RequestHelper::getSegmentContent(2);

        if (
            Branch::getOneByColumn(
                Branch::$table, 'name', 'id', $id
            ) === null
        ) {
            return ResponseHelper::createNotFound();
        }

        Branch::deleteOne(Branch::$table, $id);

        return ResponseHelper::createSuccessDeleteData();
    }
}
