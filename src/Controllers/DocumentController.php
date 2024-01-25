<?php

namespace Src\Controllers;

use Src\Helpers\RequestHelper;
use Src\Helpers\ResponseHelper;
use Src\Models\Document;
use Src\Requests\CountDocumentRequest;
use Src\Requests\GetDocumentRequest;
use Src\Requests\StoreDocumentRequest;
use Src\Requests\UpdateDocumentRequest;

class DocumentController
{
    function list() {
        $request = new GetDocumentRequest;

        $data['rules'] = $request->input;

        $data['list'] = Document::get($data['rules']);

        return ResponseHelper::createSuccessGetData($data);
    }

    function count() {
        $request = new CountDocumentRequest;

        $data['rules'] = $request->input;

        $data['total'] = Document::count($data['rules']);

        return ResponseHelper::createSuccessGetData($data);
    }

    function getOne() {
        $data = Document::getOneByColumn(
            Document::$table, Document::$columns, 'id',
            RequestHelper::getSegmentContent(2)
        );

        return $data === null
                ? ResponseHelper::createNotFound()
                : ResponseHelper::createSuccessGetData($data);
    }

    function create() {
        $request = new StoreDocumentRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest($request->validation['messages']);
        }

        Document::insertOne(Document::$table, $request->input);

        return ResponseHelper::createSuccessCreateData($request->input);
    }

    function update() {
        $id = RequestHelper::getSegmentContent(2);

        $data = Document::getOneByColumn(
            Document::$table, Document::$columns, 'id', $id
        );

        if ($data === null) {
            return ResponseHelper::createNotFound();
        }

        $request = new UpdateDocumentRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest($request->validation['messages']);
        }

        Document::updateOne(Document::$table, $request->input, $id);

        return ResponseHelper::createSuccessUpdateData($request->input);
    }

    function delete() {
        $id = RequestHelper::getSegmentContent(2);

        $data = Document::getOneByColumn(
            Document::$table, 'id', 'id', $id
        );

        if ($data === null) {
            return ResponseHelper::createNotFound();
        }

        Document::deleteOne(Document::$table, $id);

        return ResponseHelper::createSuccessDeleteData();
    }
}
