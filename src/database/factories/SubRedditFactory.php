<?php

use Faker\Generator as Faker;
use FeedMe\Models\SubReddit;

$factory->define(SubReddit::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
        'title' => $faker->words(5, true),
    ];
});
