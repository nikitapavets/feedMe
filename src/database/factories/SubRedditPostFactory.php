<?php

use Faker\Generator as Faker;
use FeedMe\Models\SubRedditPost;

$factory->define(SubRedditPost::class, function (Faker $faker) {
    return [
        'name'        => $faker->word,
        'title'       => $faker->words(5, true),
        'description' => $faker->words(50, true),
        'author'      => $faker->userName,
        'domain'      => $faker->domainName,
        'url'         => $faker->url,
        'permalink'   => $faker->url,
        'ups'         => $faker->numberBetween(1, 1000),
    ];
});
