<?php

namespace NikitaPavets\Reddit;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class RedditServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/reddit.php' => config_path('reddit.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/reddit.php', 'reddit'
        );

        $this->app->singleton('reddit', function ($app) {
            $client = new Client([
                'timeout' => 5.0,
                'headers' => [
                    'User-Agent' => 'feedMe',
                ],
            ]);

            return new RedditService($client);
        });
    }
}
