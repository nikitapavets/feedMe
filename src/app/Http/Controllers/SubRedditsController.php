<?php

namespace FeedMe\Http\Controllers;

use FeedMe\Exceptions\AlreadyExistException;
use FeedMe\Http\Requests\SubRedditStoreRequest;
use FeedMe\Models\SubReddit;
use FeedMe\Services\SubRedditService;
use NikitaPavets\Reddit\RedditFacade;

class SubRedditsController extends Controller
{
    public function index()
    {
        $subreddits = SubReddit::orderByDesc('id')->paginate();

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
        $subRedditTitle = $request->name;
        $subReddit = SubReddit::where('title', $subRedditTitle)->first();

        if ($subReddit) {
            throw new AlreadyExistException();
        }

        $subRedditInfo = RedditFacade::getSubRedditInfo(
            $subRedditTitle,
            $subRedditService->getLastPostNameBySubRedditTitle($subRedditTitle)
        );
        $subReddit = $subRedditService->storeSubRedditInfo($subRedditInfo);

        return response()->success($subReddit);
    }
}
