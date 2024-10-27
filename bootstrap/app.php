<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpFoundation\Response;

use App\Helpers\Helper;
# Middleware check token hết hạn
use App\Http\Middleware\CheckTokenExpiration;
# Middleware chặn account đang bị khóa
use App\Http\Middleware\DenyInactiveAccount;
# Middleware params request vào file log
use App\Http\Middleware\LogRequestParams;
// use App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(CheckTokenExpiration::class);
        $middleware->append(DenyInactiveAccount::class);
        $middleware->append(LogRequestParams::class);
        // $middleware->append(AdminMiddleware::class);
        $middleware->alias([
            'locale' => \App\Http\Middleware\Locale::class,
            'auth' => \App\Http\Middleware\Authenticate::class,
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
            'customer.auth' => \App\Http\Middleware\CustomerAuth::class,
            'partner.auth' => \App\Http\Middleware\PartnerAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e) {
            $statusCode = null;
            $message = null;
 
            switch (true) {
                case $e instanceof BadRequestHttpException:
                    $message = __('common.response_code.400');
                    $statusCode = Response::HTTP_BAD_REQUEST;
                    break;
 
                case $e instanceof AccessDeniedHttpException:
                    $message = __('common.response_code.403');
                    $statusCode = Response::HTTP_FORBIDDEN;
                    break;
 
                case $e instanceof NotFoundHttpException:
                    $message = __('common.response_code.404');
                    $statusCode = Response::HTTP_NOT_FOUND;
                    break;
 
                case $e instanceof MethodNotAllowedHttpException:
                    $message = __('common.response_code.405');
                    $statusCode = Response::HTTP_METHOD_NOT_ALLOWED;
                    break;
 
                default:
                    break;
            }
 
            // if (!empty($statusCode)) {
            //     # Log error
            //     $errorLog = array(
            //         'module'    => request()->getMethod(),
            //         'action'    => request()->getRequestUri(),
            //         'msg_log'   => getMessage($e)
            //     );
            //     Helper::trackingError($errorLog);
                
            //     # Response
            //     $response = [
            //         'success' => false,
            //         'message' => $message,
            //         'data'   => []
            //     ];
            //     return response()->json($response, $statusCode);
            // }
        });
    })->create();
