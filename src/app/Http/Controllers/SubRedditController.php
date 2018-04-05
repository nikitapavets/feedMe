<?php

namespace FeedMe\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SubRedditController extends Controller
{
    public function index()
    {
        Artisan::call('subreddit:get', [
            'subreddit_title' => 'javascript'
        ]);
    }
}
