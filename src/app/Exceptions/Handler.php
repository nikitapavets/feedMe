<?php

namespace FeedMe\Exceptions;

use Exception;
use FeedMe\Providers\ResponseServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
            //
        ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
            'password',
            'password_confirmation',
        ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     *
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * @param $request
     * @param Exception $exception
     * @return mixed
     * @throws InternalServerErrorHttpException
     * @throws \FeedMe\Exceptions\AuthorizationException
     * @throws \FeedMe\Exceptions\BadRequestHttpException
     * @throws \FeedMe\Exceptions\NotFoundHttpException
     */
    public function render($request, Exception $exception)
    {
        switch ($exception) {
            case ($exception instanceof AuthorizationException):
                {
                    throw new \FeedMe\Exceptions\AuthorizationException();
                }
            case ($exception instanceof ValidationException):
                {
                    throw new \FeedMe\Exceptions\BadRequestHttpException($exception->getResponse()->original);
                }
            case ($exception instanceof BadRequestHttpException):
                {
                    throw new \FeedMe\Exceptions\BadRequestHttpException();
                }
            case ($exception instanceof ModelNotFoundException):
            case ($exception instanceof NotFoundHttpException):
                {
                    throw new \FeedMe\Exceptions\NotFoundHttpException();
                }
            case ($exception instanceof \FeedMe\Exceptions\NotFoundHttpException):
            case ($exception instanceof \FeedMe\Exceptions\AuthorizationException):
            case ($exception instanceof \FeedMe\Exceptions\BadRequestHttpException):
            case ($exception instanceof \FeedMe\Exceptions\AlreadyExistException):
            case ($exception instanceof InternalServerErrorHttpException):
                {
                    return response()->error(
                        $exception->getMessage(),
                        $exception->getCode()
                    );
                }
            default:
                {
                    if (config('app.debug')) {
                        return parent::render($request, $exception);
                    }

                    throw new InternalServerErrorHttpException();
                }
        }
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(
                ['error' => 'Unauthenticated.'],
                ResponseServiceProvider::HTTP_RESPONSE_FORBIDDEN);
        }

        return redirect()->guest(route('login'));
    }
}
