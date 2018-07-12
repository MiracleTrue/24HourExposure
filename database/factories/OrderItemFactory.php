<?php

use Faker\Generator as Faker;

$factory->define(App\Models\OrderItem::class, function (Faker $faker) {
    // 现在时间
    $now = \Carbon\Carbon::now()->toDateTimeString();

    $gifts = \App\Models\Gift::all()->pluck('id')->toArray();

    return [
        'gift_id' => $faker->randomElement($gifts),
        'number' => $faker->randomElement([1, 2, 3, 4]),
        'item_price' => $faker->randomFloat(2, 10, 200),
    ];
});
