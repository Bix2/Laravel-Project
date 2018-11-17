<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            HabitsSeeder::class,
            UsersSeeder::class,
            ActivitylogsSeeder::class,
            BreathingSeeder::class,
            SleeplogsSeeder::class,
            WaterlogsSeeder::class
        ]);
    }
}
