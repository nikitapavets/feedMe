<?php

namespace NikitaPavets\Reddit;

use Illuminate\Support\Facades\Facade;

class RedditFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'reddit';
    }
}
