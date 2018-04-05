<?php

namespace FeedMe\Console\Commands\Reddit;

use FeedMe\Models\SubReddit;
use FeedMe\Models\SubRedditPost;
use FeedMe\Services\SubRedditService;
use Illuminate\Console\Command;
use NikitaPavets\Reddit\RedditFacade;

class DownloadSubreddit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subreddit:get {subreddit_title}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get full information of the subreddit.';

    /**
     * @var SubRedditService
     */
    private $subRedditService;

    public function __construct(SubRedditService $subRedditService)
    {
        parent::__construct();

        $this->subRedditService = $subRedditService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $subRedditInfo = $this->getSubRedditInfo();
        $this->storeSubRedditInfo($subRedditInfo);
    }

    /**
     * @return array
     */
    private function getSubRedditInfo()
    {
        $subRedditTitle = $this->argument('subreddit_title');

        $this->info("Getting {$subRedditTitle} posts...");

        $subRedditInfo = RedditFacade::getSubRedditInfo(
            $subRedditTitle,
            $this->subRedditService->getLastPostNameBySubRedditTitle($subRedditTitle)
        );

        $this->info("Done!");

        return $subRedditInfo;
    }

    /**
     * @param array $subRedditInfo
     */
    private function storeSubRedditInfo($subRedditInfo)
    {
        $this->info("Storing...");

        $subReddit = SubReddit::updateOrCreate(['name' => $subRedditInfo['name']], $subRedditInfo);

        $subRedditPosts = [];
        $bar = $this->output->createProgressBar($subRedditInfo['posts_count']);
        foreach ($subRedditInfo['posts'] as $subRedditPostData) {
            $subRedditPosts[] = array_merge($subRedditPostData, [
                'sub_reddit_id' => $subReddit->id,
            ]);
            $bar->advance();
        }
        SubRedditPost::insert($subRedditPosts);
        $bar->finish();

        $this->info("\nDone!");
    }
}
