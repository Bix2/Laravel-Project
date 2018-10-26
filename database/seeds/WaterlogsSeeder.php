<?php

use Illuminate\Database\Seeder;

class WaterlogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Waterlogs::class, 100)->create();
    }
}
