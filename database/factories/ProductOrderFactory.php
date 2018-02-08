<?php

use Faker\Generator as Faker;

$factory->define(App\ProductOrder::class, function (Faker $faker) {
    return [
        'product_id' => 1,
        'order_id' => 1,
        'total_price' => 1,
        'total_quantity' => 1,
        'status' => 'confirmed',
        'cancel_flag' => 0,
    ];
});
