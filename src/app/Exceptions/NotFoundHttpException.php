<?php

namespace FeedMe\Exceptions;


use FeedMe\Providers\ResponseServiceProvider;
use Exception;
use Throwable;

class NotFoundHttpException extends Exception
{
    protected $code = ResponseServiceProvider::HTTP_RESPONSE_NOT_FOUND;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message ? $message : __('errors.not_found');

        parent::__construct($message, $code, $previous);
    }
}