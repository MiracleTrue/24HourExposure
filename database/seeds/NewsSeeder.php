<?php

use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //获取所有的主表数据，并返回一个集合 Collection。
        \App\Models\NewsCategory::all()->each(function ($object) {
            //对每一个主表数据，产生一个 x - x 的随机数的数据。
            //同时指定这批数据的 外键 字段统一为当前循环的 ID。
            $object = factory(\App\Models\News::class, random_int(3, 6))->create(['category_id' => $object->id]);

        });
    }
}
