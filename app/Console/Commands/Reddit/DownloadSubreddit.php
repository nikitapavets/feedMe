<?php

namespace FeedMe\Console\Commands\Reddit;

use Illuminate\Console\Command;
use NikitaPavets\Reddit\RedditFacade;

class DownloadSubreddit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reddit:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get full information of the subreddit.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dd(RedditFacade::getSubRedditInfo('javascript'));
    }
}
