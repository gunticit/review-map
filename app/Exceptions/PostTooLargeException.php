<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\BaseException;
use App\Helpers\Helper;
use Illuminate\Http\Exceptions\PostTooLargeException as LibPostTooLargeException;

class PostTooLargeException extends BaseException
{
    public function __construct($exception)
    {
        parent::__construct($exception, Response::HTTP_FORBIDDEN);
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render($request, LibPostTooLargeException $exception)
    {
        if ($exception instanceof PostTooLargeException) {
            // Trả về phản hồi lỗi tùy chỉnh cho người dùng
            return response()->json([
                'error' => 'Tệp tải lên quá lớn. Vui lòng chọn tệp nhỏ hơn.'
            ], Response::HTTP_REQUEST_ENTITY_TOO_LARGE); // Mã lỗi 413
        }

        // Các lỗi khác được xử lý bởi phương thức mặc định
        return parent::render($request, $exception);
    }
}
