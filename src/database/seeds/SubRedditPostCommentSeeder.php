<?php

use Illuminate\Database\Seeder;
use FeedMe\Models\SubRedditPostComment;

class SubRedditPostCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(SubRedditPostComment::class)->create([
            'id'                 => config('seeder.default.id'),
            'sub_reddit_post_id' => config('seeder.default.id'),
            'parent_id'          => config('seeder.default.id'),
        ]);
    }
}
