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
    protected $signature = 'subreddit:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get full information of a subreddit.';

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
        $subreddit = SubReddit::orderBy('updated_at')->first();

        $subRedditInfo = RedditFacade::getSubRedditInfo(
            $subreddit->title,
            $this->subRedditService->getLastPostNameBySubRedditTitle($subreddit->title)
        );
        $subReddit = $this->subRedditService->storeSubRedditInfo($subRedditInfo);

        $subReddit->posts()->each(function(SubRedditPost $post) {
            $post->comments()->delete();
            $postCommentsInfo = RedditFacade::getPostComments(
                $post->permalink,
                $this->subRedditService->getLastCommentNameByPost($post)
            );
            $this->subRedditService->storePostCommentsInfo($postCommentsInfo, $post->id, config('seeder.default.id'));
        });

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
