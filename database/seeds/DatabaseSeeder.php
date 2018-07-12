<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $this->call(AdminTablesSeeder::class);

        //用户
        $this->call(UsersSeeder::class);

        //位置
        $this->call(LocationsSeeder::class);

        //新闻
        $this->call(NewsCategoriesSeeder::class);
        $this->call(NewsSeeder::class);

        //曝光
        $this->call(ExposureCategoriesSeeder::class);
        $this->call(ExposuresSeeder::class);
        $this->call(ExposureCommentsSeeder::class);

        //礼物
        $this->call(GiftsSeeder::class);

    }
}
