<?php

use Illuminate\Database\Seeder;

class ExposuresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //获取所有的主表数据，并返回一个集合 Collection。
        \App\Models\ExposureCategory::all()->each(function ($object) {
            //对每一个主表数据，产生一个 x - x 的随机数的数据。
            //同时指定这批数据的 外键 字段统一为当前循环的 ID。
            $object = factory(\App\Models\Exposure::class, random_int(4, 8))->create([
                'category_id' => $object->id,
            ]);

        });
    }
}
