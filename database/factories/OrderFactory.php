<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'customer_id' => 1,
        'customer_name' => $faker->name,
        'billing_address' => $faker->address,
        'zipcode' => rand(1,4),
        'confirmation_date' => date('Y-m-d'),
    ];
});
