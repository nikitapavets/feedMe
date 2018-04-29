<?php

namespace FeedMe\Http\Controllers;

use FeedMe\Exceptions\AlreadyExistException;
use FeedMe\Http\Requests\SubRedditStoreRequest;
use FeedMe\Models\SubReddit;
use FeedMe\Models\SubRedditPost;
use FeedMe\Services\SubRedditService;
use NikitaPavets\Reddit\RedditFacade;

class PostsController extends Controller
{
    public function show($postName, SubRedditService $subRedditService)
    {
        $post = SubRedditPost::where('name', $postName)->firstOrFail();

        $post->comments()->delete();
        $postCommentsInfo = RedditFacade::getPostComments(
            $post->permalink,
            $subRedditService->getLastCommentNameByPost($post)
        );
        $subRedditService->storePostCommentsInfo($postCommentsInfo, $post->id, config('seeder.default.id'));

        $post->makeVisible(['comments_grid']);

        return response()->success($post);
    }
}
