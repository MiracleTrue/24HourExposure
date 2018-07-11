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
    }
}
