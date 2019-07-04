<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Character::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'gender' => $faker->randomElement(['male', 'female']),
        'age' => $faker->numberBetween(1, 130),
        'eye_color' => $faker->colorName,
        'hair_color'=> $faker->colorName
    ];
});
