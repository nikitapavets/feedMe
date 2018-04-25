<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubRedditPostCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_reddit_post_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sub_reddit_post_id');
            $table->unsignedInteger('parent_id');
            $table->string('name')->unique();
            $table->text('message');
            $table->string('author');
            $table->string('permalink');
            $table->integer('ups');
            $table->timestamps();
        });

        Schema::table('sub_reddit_post_comments', function (Blueprint $table) {
            $table->foreign('sub_reddit_post_id')->references('id')->on('sub_reddit_posts')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('sub_reddit_post_comments', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('sub_reddit_post_comments')
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
        Schema::table('sub_reddit_post_comments', function (Blueprint $table) {
            $table->dropForeign(['sub_reddit_post_id']);
            $table->dropForeign(['parent_id']);
        });

        Schema::dropIfExists('sub_reddit_post_comments');
    }
}
