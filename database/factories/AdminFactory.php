<?php

use Faker\Generator as Faker;

$factory->define(App\Admin::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'name' => $faker->name,
        'type' => 'superadmin',
        'status' => 0,
    ];
});
