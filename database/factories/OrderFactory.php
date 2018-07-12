<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Order::class, function (Faker $faker) {
    // 现在时间
    $now = \Carbon\Carbon::now()->toDateTimeString();

    // 随机取一个月以内的时间
    $updated_at = $faker->dateTimeThisMonth();
    // 传参为生成最大时间不超过，创建时间永远比更改时间要早
    $created_at = $faker->dateTimeThisMonth($updated_at);


    $users = \App\Models\User::all()->pluck('id')->toArray();

    return [
        'user_id' => $faker->randomElement($users),
        'no' => $faker->randomNumber(8) . $faker->randomNumber(8),
        'total_amount' => $faker->randomFloat(2, 10, 200),
        'paid_at' => $now,
        'payment_method' => 'alipay',
        'payment_title' => '支付测试',
        'payment_no' => $faker->randomNumber(8),
        'closed' => false,
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
