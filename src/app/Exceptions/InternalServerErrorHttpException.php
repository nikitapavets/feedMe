<?php

namespace FeedMe\Exceptions;


use FeedMe\Providers\ResponseServiceProvider;
use Exception;
use Throwable;

class InternalServerErrorHttpException extends Exception
{
    protected $code = ResponseServiceProvider::HTTP_RESPONSE_SERVER_ERROR;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message ? $message : __('errors.internal_server_error');

        parent::__construct($message, $code, $previous);
    }
}