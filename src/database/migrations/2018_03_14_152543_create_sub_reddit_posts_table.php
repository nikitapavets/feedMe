<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubRedditPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_reddit_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sub_reddit_id');
            $table->string('name')->unique();
            $table->string('title', 1000);
            $table->text('description')->nullable();
            $table->string('author');
            $table->string('domain');
            $table->string('permalink');
            $table->string('url');
            $table->integer('ups');
            $table->timestamps();
        });

        Schema::table('sub_reddit_posts', function (Blueprint $table) {
            $table->foreign('sub_reddit_id')->references('id')->on('sub_reddits')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_reddit_posts', function (Blueprint $table) {
            $table->dropForeign(['sub_reddit_id']);
        });

        Schema::dropIfExists('sub_reddit_posts');
    }
}
