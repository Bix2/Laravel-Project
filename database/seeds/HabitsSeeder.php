<?php

use Illuminate\Database\Seeder;

class HabitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('habits')->insert([
            'type' => 'sleep',
            'short_description' => 'Your Sleep Pattern',
            'long_description' => 'CodeBreak helps you better understand your sleep patterns and quality through a range of sleep tools',
            'watch'             =>  true,
            'fitbit_app'        =>  false,
            'codebreak'         =>  false,
        ]);

        DB::table('habits')->insert([
            'type' => 'breathing',
            'short_description' => 'Your Breathing Sessions',
            'long_description' => 'Turns out all you need is a pair of healthy lungs',
            'watch'             =>  false,
            'fitbit_app'        =>  false,
            'codebreak'         =>  true,
        ]);

        DB::table('habits')->insert([
            'type' => 'exercise',
            'short_description' => 'Your Activity',
            'long_description' => 'CodeBreak helps you relax after some coding hours',
            'watch'             =>  true,
            'fitbit_app'        =>  true,
            'codebreak'         =>  true,
        ]);

        DB::table('habits')->insert([
            'type' => 'water',
            'short_description' => 'Your Hydration Status',
            'long_description' => 'CodeBreak helps you drink liquids more often',
            'watch'             =>  true,
            'fitbit_app'        =>  true,
            'codebreak'         =>  true,
        ]);
    }
}
