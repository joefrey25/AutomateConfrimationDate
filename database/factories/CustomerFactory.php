<?php

use Faker\Generator as Faker;

$factory->define(App\Customer::class, function (Faker $faker) {
    return [
        'user_id' => 2,
        'firstname' => $faker->name,
        'lastname' => $faker->name,
        'status' => 0,
        'address' => $faker->address,
    ];
});
