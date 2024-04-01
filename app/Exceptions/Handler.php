<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use \App\Helpers\Trait\ApiResponseHelpers;

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
            return false;
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request, Throwable $exception)
    {
        report($exception);

        switch (true) {
            case $exception instanceof AuthenticationException:
                return $this->respondUnAuthenticated($exception->getMessage());
                break;

            case $exception instanceof ModelNotFoundException:
                return $this->respondNotFound(__('No query results for model'));
                break;

            case $exception instanceof MethodNotAllowedHttpException:
                return $this->respondError(__('Method is not allowed'));
                break;

            /*case $exception instanceof ValidationException:
                return $this->respondFailedValidation(__('The given data was invalid.'));
                break;*/

            case $exception instanceof NotFoundHttpException:
                return $this->respondNotFound(__('No result found.'));
                break;

            case $exception instanceof HttpException:
                return $this->respondError($exception->getMessage());
                break;
            
            default:
                return parent::render($request, $exception);
                break;
        }

        return $this->respondError(__("Your request can't be processed."));
    }
}
