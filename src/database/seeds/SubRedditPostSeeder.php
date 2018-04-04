<?php

use Illuminate\Database\Seeder;
use FeedMe\Models\SubReddit;
use FeedMe\Models\SubRedditPost;

class SubRedditPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubReddit::all()->each(function (SubReddit $subReddit) {
            $subReddit->posts()->saveMany(
                factory(SubRedditPost::class, config('seeder.count.sub_reddit_posts'))->make()
            );
        });
    }
}
