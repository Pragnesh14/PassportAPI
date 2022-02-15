<?php

namespace App\Http\Controllers\API\Common;

use App\Http\Controllers\Controller;

class ResponseController extends Controller
{
    public function sendResponse($result, $code)
    {
        $response = [
            'success' => true,
        ];
        if (count($result) > 0) {
            $response['data'] = $result;
        }
        return response()->json($response, $code);
    }

    public function sendError($code = 404, $errorMessages = [])
    {
        $response = [
            'success' => false,
        ];
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}
