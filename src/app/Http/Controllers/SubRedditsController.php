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
//            'subreddit_title' => 'javascript'
//        ]);

        $subreddits = SubReddit::paginate();

        return response()->success($subreddits);
    }
}
