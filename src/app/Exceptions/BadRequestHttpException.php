<?php

namespace FeedMe\Exceptions;


use FeedMe\Providers\ResponseServiceProvider;
use Exception;
use Throwable;

class BadRequestHttpException extends Exception
{
    protected $code = ResponseServiceProvider::HTTP_RESPONSE_BAD_REQUEST;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message ? $message : __('errors.bad_request');

        parent::__construct($message, $code, $previous);
    }
}