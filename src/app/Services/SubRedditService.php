<?php

namespace FeedMe\Services;

use FeedMe\Models\SubReddit;
use FeedMe\Models\SubRedditPost;
use FeedMe\Models\SubRedditPostComment;

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
     * @param SubRedditPost $post
     *
     * @return mixed|null
     */
    public function getLastCommentNameByPost(SubRedditPost $post)
    {
        $lastComment = $post->comments()->orderByDesc('id')->first();

        return $lastComment ? $lastComment->name : null;
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


    public function storePostCommentsInfo($postCommentsInfo, $postId, $parentId)
    {
        foreach ($postCommentsInfo as $commentInfo) {
            $commentEntity = SubRedditPostComment::create(array_merge($commentInfo, [
                'sub_reddit_post_id' => $postId,
                'parent_id'          => $parentId,
            ]));

            if ($commentInfo['children']) {
                $this->storePostCommentsInfo($commentInfo['children'], $postId, $commentEntity->id);
            }
        }
    }
}
