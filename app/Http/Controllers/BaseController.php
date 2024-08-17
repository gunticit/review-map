<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller as Controller;
class BaseController extends Controller
{
    use AuthorizesRequests;

    /**
     * success response method.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($result, $message = "Success")
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $errorMessages, $code = 404)
    {
        $response = [
            'success' => false,
            'data'    => [], 
        ];

        if($errorMessages != null){
            $response['message'] = $errorMessages;
        }else{
            $bagError = new \Illuminate\Support\MessageBag;
            $bagError->add('exception', $error);
            $response['message'] = $bagError;
        }

        return response()->json($response, $code);
    }

    public function getLang()
    {
        return 'vi';
    }
}
