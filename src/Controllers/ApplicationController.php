<?php

namespace Src\Controllers;

use Src\Configurations\Environment;
use Src\Helpers\ResponseHelper;
use Src\Helpers\TimeHelper;
use Src\Requests\UpdateApplicationRequest;

class ApplicationController
{
    function get() {
        $filePath = './src/Storage/Application/app';

        if (file_exists($filePath)) {
            return ResponseHelper::createSuccessGetData(
                unserialize(file_get_contents($filePath))
            );
        }

        return ResponseHelper::createSuccessGetData([
            'name' => 'HRM',
            'status' => 1,
            'desktopImage' => Environment::$value['baseURL'] . 'assets/images/logo.png',
            'tabImage' => Environment::$value['baseURL'] . 'assets/images/logo.png',
            'mobileImage' => Environment::$value['baseURL'] . 'assets/images/logo.png',
            'createdAt' => null,
            'updatedAt' => null
        ]);
    }

    function update() {
        $request = new UpdateApplicationRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest($request->validation['messages']);
        }

        $filePath = './src/Storage/Application/app';

        if (file_exists($filePath)) {
            $data = unserialize(file_get_contents($filePath));
        } else {
            $data = [
                'name' => 'HRM',
                'status' => 1,
                'desktopImage' => 'assets/images/logo.png',
                'tabletImage' => 'assets/images/logo.png',
                'mobileImage' => 'assets/images/logo.png',
            ];
        }

        if ($request->input['desktopImage'] !== null) {
            $request->input['desktopImage'] = $this->upload($request->desktopImage, 'desktop');

            if (!$request->input['desktopImage']) {
                return ResponseHelper::createInternalServerError();
            }
        } else {
            $request->input['desktopImage'] = $data['desktopImage'];
        }

        if ($request->input['tabletImage'] !== null) {
            $request->input['tabletImage'] = $this->upload($request->tabletImage, 'tablet');

            if (!$request->input['tabletImage']) {
                return ResponseHelper::createInternalServerError();
            }
        } else {
            $request->input['tabletImage'] = $data['tabletImage'];
        }

        if ($request->input['mobileImage'] !== null) {
            $request->input['mobileImage'] = $this->upload($request->mobileImage, 'mobile');

            if (!$request->input['mobileImage']) {
                return ResponseHelper::createInternalServerError();
            }
        } else {
            $request->input['mobileImage'] = $data['mobileImage'];
        }

        $filePath = './src/Storage/Application/app';

        $request->input['createdAt'] = TimeHelper::createTimeNow();
        $request->input['updatedAt'] = $request->input['createdAt'];

        if (!file_put_contents($filePath, serialize($request->input))) {
            return ResponseHelper::createInternalServerError();
        }

        $request->input['mobileImage'] = $this->createURL($request->input['mobileImage']);

        $request->input['tabletImage'] = $this->createURL($request->input['tabletImage']);

        $request->input['desktopImage'] = $this->createURL($request->input['desktopImage']);

        return ResponseHelper::createSuccessUpdateData($request->input);
    }

    private function upload($image, $name) {
        $filePath = 'assets/images/' . $name . '.png';

        if (!file_put_contents('./' . $filePath, $image)) {
            return 0;
        }

        return $filePath;
    }

    private function createURL($path) {
        return Environment::$value['baseURL'] . $path;
    }
}
