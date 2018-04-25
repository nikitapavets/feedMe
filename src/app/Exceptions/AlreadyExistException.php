<?php

namespace FeedMe\Exceptions;


use FeedMe\Providers\ResponseServiceProvider;
use Exception;
use Throwable;

class AlreadyExistException extends Exception
{
    protected $code = ResponseServiceProvider::HTTP_RESPONSE_CONFLICT;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message ? $message : __('errors.already_exist');

        parent::__construct($message, $code, $previous);
    }
}