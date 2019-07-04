<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Film::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'description' => $faker->text,
        'director' => $faker->name,
        'producer' => $faker->name,
        'release_date' => $faker->numberBetween(1980, 2019),
        'score' => $faker->numberBetween(0, 100) 
    ];
});
