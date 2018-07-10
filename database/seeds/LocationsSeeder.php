<?php

use Illuminate\Database\Seeder;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        //单独处理第一个条数据
        \App\Models\Location::create(
            [
                'nation' => '中国',
                'province' => '山东省',
                'city' => '青岛市'
            ]
        );
    }
}
