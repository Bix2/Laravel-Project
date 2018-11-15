<?php

use Illuminate\Database\Seeder;

class BreathingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Breathing::class, 100)->create();
    }
}
