<?php

use Illuminate\Database\Seeder;

class SleeplogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Sleeplogs::class, 100)->create();
    }
}
