<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(SubRedditSeeder::class);
         $this->call(SubRedditPostSeeder::class);
         $this->call(SubRedditPostCommentSeeder::class);
    }
}
