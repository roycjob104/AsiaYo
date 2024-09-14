<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    }

    public function render($request, Throwable $exception)
    {
        // 確保以 /api 開頭的路徑返回 JSON
        if ($request->is('api/*')) {
            if ($exception instanceof ModelNotFoundException) {
                return response()->json(['message' => 'Record not found.'], Response::HTTP_NOT_FOUND);
            }

            if ($exception instanceof NotFoundHttpException) {
                return response()->json(['message' => 'Endpoint not found.'], Response::HTTP_NOT_FOUND);
            }

            if ($exception instanceof ValidationException) {
                return response()->json(['errors' => $exception->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // 針對所有其他例外
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        // 如果不是 /api 路徑則使用預設行為
        return parent::render($request, $exception);
    }
}
