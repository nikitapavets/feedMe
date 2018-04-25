<?php

use Faker\Generator as Faker;
use FeedMe\Models\SubRedditPostComment;

$factory->define(SubRedditPostComment::class, function (Faker $faker) {
    return [
        'name'        => $faker->word,
        'message' => $faker->words(50, true),
        'author'      => $faker->userName,
        'permalink'   => $faker->url,
        'ups'         => $faker->numberBetween(1, 1000),
    ];
});
