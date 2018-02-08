<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text(200),
        'price' => 1,
        'quantity' => 1,
        'image' => NULL,
        'status' => 0,
    ];
});
