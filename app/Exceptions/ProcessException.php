<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\BaseException;
use App\Helpers\Helper;

class ProcessException extends BaseException
{
    public function __construct($exception)
    {
        parent::__construct($exception, Response::HTTP_FORBIDDEN);
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        $this->trackingLog($request);
        return $this->jsonResponse();
    }
}
