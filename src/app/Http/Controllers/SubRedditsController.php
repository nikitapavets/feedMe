<?php

namespace FeedMe\Http\Controllers;

use FeedMe\Models\SubReddit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SubRedditsController extends Controller
{
    public function index()
    {
//        Artisan::call('subreddit:get', [
//            'subreddit_title' => 'worldnews'
//        ]);

        $subreddits = SubReddit::paginate();

        return response()->success($subreddits);
    }

    public function show($subRedditName)
    {
        $subReddit = SubReddit::where('name', $subRedditName)->firstOrFail();
        $subReddit->load(['posts']);

        return response()->success($subReddit);
    }
}
