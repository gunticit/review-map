<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Helpers\Helper;

class BaseException extends Exception
{
    protected $exception;
    protected $code;

    public function __construct($exception, $code)
    {
        $this->exception = $exception;
        $this->code = $code;
        parent::__construct($this->exception->getMessage(), $this->code);
    }

    public function jsonResponse($message = null, $data = []): JsonResponse
    {
        $response = [
            'success' => false,
            'data'    => $data,
            'message' => $message?? $this->getMessage()
        ];
        return response()->json($response, $this->code);
    }

    public function trackingLog($request): void
    {
        $errorLog = array(
            'module'    => $request->getMethod(),
            'action'    => $request->getRequestUri(),
            'msg_log'   => $this->exception
        );
        Helper::trackingError($errorLog);
    }
}
