<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected $withoutDuplicates = true;

    
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            
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

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->is('api/*')) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
            ], 401);
        }

        return parent::unauthenticated($request, $exception);
    }
}
