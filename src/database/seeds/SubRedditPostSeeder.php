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
        factory(SubRedditPost::class)->create([
            'id' => config('seeder.default.id'),
            'sub_reddit_id' => config('seeder.default.id'),
            'name' => config('seeder.default.value'),
        ]);
    }
}
