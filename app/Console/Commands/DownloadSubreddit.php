<?php

namespace FeedMe\Console\Commands;

use Illuminate\Console\Command;

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
        $this->info("#> Start to download subreddit.");
    }
}
