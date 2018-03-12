<?php

namespace FeedMe\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use NikitaPavets\Reddit\RedditFacade;

class DownloadSubreddit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subreddit:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download full information of the subreddit.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        RedditFacade::test();

        $client = new Client([
            // Base URI is used with relative requests
            // You can set any number of default request options.
            'timeout'  => 2.0,
            'headers' => [
                'User-Agent' => 'testing/1.0'
            ]
        ]);
        $response = $client->get('https://reddit.com/subreddits/default.json');
        dd(json_decode($response->getBody(), true));
    }
}
