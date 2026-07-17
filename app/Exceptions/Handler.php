<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected $withoutDuplicates = true;

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (HttpException $exception, Request $request) {
            if ($request->is('api/*') && $this->isHttpException($exception)) {
                switch($exception->getStatusCode()) {
                    case 401:
                        return response()->json([
                            'status' => 401,
                            'message' => 'Unauthorized'
                        ], 401);
                    break;
                    case 403:
                        return response()->json([
                            'status' => 403,
                            'message' => 'Forbidden'
                        ], 403);
                    break;
                    case 404:
                        return response()->json([
                            'status' => 404,
                            'message' => 'Not Found'
                        ], 404);
                    break;
                }
            }
        });
    }
}
