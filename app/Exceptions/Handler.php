<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
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

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        $errorMessage = 'unknown';
        $httpStatus = Response::HTTP_BAD_REQUEST;
        switch (! is_null($e)) {
            case $e instanceof RecordsNotFoundException:
                $model = $e->getModel();
                $modelName = class_basename($model);
                Log::error($modelName.' not found');
                $errorMessage = 'Record not found.';
                $httpStatus = Response::HTTP_NOT_FOUND;

                break;
            case $e instanceof AuthenticationException:
                $errorMessage = 'Unauthenticated';
                $httpStatus = Response::HTTP_UNAUTHORIZED;

                break;
            case $e instanceof ValidationException:
                $flattened = Arr::flatten($e->validator->errors()->all());
                $errorMessage = implode(' ,', $flattened);
                $httpStatus = $e->getCode() == 0 ? Response::HTTP_BAD_REQUEST : $e->getCode();

                break;
            case $e instanceof TokenMismatchException:
                $errorMessage = $e->getMessage();
                $httpStatus = $e->getCode() == 0 ? Response::HTTP_BAD_REQUEST : $e->getCode();

                break;
            case $e instanceof ConflictException:
                $errorMessage = $e->getMessage();
                $httpStatus = Response::HTTP_CONFLICT;

                break;
            default:
                $errorMessage = $e->getMessage();

                break;
        }

        return response()->json([
            'message' => $errorMessage,
        ], $httpStatus);
    }
}
