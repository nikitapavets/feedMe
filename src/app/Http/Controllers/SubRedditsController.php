<?php

namespace FeedMe\Http\Controllers;

use FeedMe\Http\Requests\SubRedditStoreRequest;
use FeedMe\Models\SubReddit;
use FeedMe\Services\SubRedditService;
use NikitaPavets\Reddit\RedditFacade;

class SubRedditsController extends Controller
{
    public function index()
    {
        $subreddits = SubReddit::paginate();

        return response()->success($subreddits);
    }

    public function show($subRedditName)
    {
        $subReddit = SubReddit::where('name', $subRedditName)->firstOrFail();
        $subReddit->load(['posts']);

        return response()->success($subReddit);
    }

    public function store(SubRedditStoreRequest $request, SubRedditService $subRedditService)
    {
        $subRedditName = $request->name;

        $subRedditInfo = RedditFacade::getSubRedditInfo(
            $subRedditName,
            $subRedditService->getLastPostNameBySubRedditTitle($subRedditName)
        );
        $subReddit = $subRedditService->storeSubRedditInfo($subRedditInfo);

        return response()->success($subReddit);
    }
}
