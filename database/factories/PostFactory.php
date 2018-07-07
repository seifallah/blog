<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->catchPhrase,
        'content' => $faker->text,
        'user_id' => rand(1,10), // secret
    ];
});
