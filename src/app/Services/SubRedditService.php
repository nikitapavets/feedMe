<?php

namespace FeedMe\Services;

use FeedMe\Models\SubReddit;
use FeedMe\Models\SubRedditPost;

class SubRedditService
{
    /**
     * @param $title
     *
     * @return null
     */
    public function getLastPostNameBySubRedditTitle($title)
    {
        $subReddit = SubReddit::where('title', $title)->first();

        if ($subReddit) {
            $lastSubRedditPost = $subReddit->posts()->orderByDesc('id')->first();
            return $lastSubRedditPost ? $lastSubRedditPost->name : null;
        }

        return null;
    }

    /**
     * @param array $subRedditInfo
     *
     * @return SubReddit
     */
    public function storeSubRedditInfo($subRedditInfo)
    {
        $subReddit = SubReddit::updateOrCreate(['name' => $subRedditInfo['name']], $subRedditInfo);

        $subRedditPosts = [];
        foreach ($subRedditInfo['posts'] as $subRedditPostData) {
            $subRedditPosts[] = array_merge($subRedditPostData, [
                'sub_reddit_id' => $subReddit->id,
            ]);
        }
        SubRedditPost::insert($subRedditPosts);

        return $subReddit;
    }
}
