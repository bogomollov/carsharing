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

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (HttpException $e, Request $request) {
            if ($request->is('api/*')) {
                if ($this->isHttpException($e)) {
                    switch($e->getStatusCode()) {
                        case 401:
                            return response()->json(['message' => 'Unauthorized'], 401);
                        break;
                        case 403:
                            return response()->json(['message' => 'Forbidden'], 403);
                        break;
                        case 404:
                            return response()->json(['message' => 'Not Found'], 404); 
                        break;
                    }
                }
            }
        });
    }
}
