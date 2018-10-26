<?php

use Illuminate\Database\Seeder;

class ActivitylogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Activitylogs::class, 100)->create();
    }
}
