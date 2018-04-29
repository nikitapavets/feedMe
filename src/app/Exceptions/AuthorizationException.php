<?php

namespace FeedMe\Exceptions;


use FeedMe\Providers\ResponseServiceProvider;
use Exception;
use Throwable;

class AuthorizationException extends Exception
{
    protected $code = ResponseServiceProvider::HTTP_RESPONSE_FORBIDDEN;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message ? $message : __('errors.forbidden');

        parent::__construct($message, $code, $previous);
    }
}
