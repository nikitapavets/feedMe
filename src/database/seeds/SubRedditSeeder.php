<?php

use Illuminate\Database\Seeder;
use FeedMe\Models\SubReddit;

class SubRedditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(SubReddit::class)->create([
            'id' => config('seeder.default.id'),
            'name' => config('seeder.default.value'),
        ]);
    }
}
