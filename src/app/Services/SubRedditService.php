<?php

namespace FeedMe\Services;

use FeedMe\Models\SubReddit;

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
}
