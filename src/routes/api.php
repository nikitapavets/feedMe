<?php

Route::apiResource('subreddits', 'SubRedditsController')->only([
    'index',
    'show',
    'store',
]);
Route::apiResource('posts', 'PostsController')->only([
    'show',
]);;
