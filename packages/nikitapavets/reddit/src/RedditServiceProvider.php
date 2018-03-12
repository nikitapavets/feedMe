<?php

namespace NikitaPavets\Reddit;

use Illuminate\Support\ServiceProvider;

class RedditServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('reddit', function ($app) {
            return new RedditService();
        });
    }
}
