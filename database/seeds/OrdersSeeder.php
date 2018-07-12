<?php

use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {


        //获取所有的主表数据，并返回一个集合 Collection。
        \App\Models\Exposure::all()->each(function ($object) {
            //对每一个主表数据，产生一个 x - x 的随机数的数据。
            //同时指定这批数据的 外键 字段统一为当前循环的 ID。
            $object = factory(\App\Models\Order::class, random_int(3, 6))->create(
                ['exposure_id' => $object->id]
            )->each(function ($order) {


                factory(\App\Models\OrderItem::class, random_int(1, 2))->create(
                    [
                        'order_id' => $order->id,
                    ]
                );


            });
        });
    }
}
