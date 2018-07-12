<?php

use Illuminate\Database\Seeder;

class GiftsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        // 通过 factory 方法生成 x 个数据并保存到数据库中
        factory(\App\Models\Gift::class, 3)->create();
    }
}
