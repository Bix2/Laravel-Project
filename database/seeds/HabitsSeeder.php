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
            'short_description' => 'Sleep Pattern',
            'long_description' => 'CodeBreak helps you better understand your sleep patterns and quality through a range of sleep tools'
        ]);

        DB::table('habits')->insert([
            'type' => 'water',
            'short_description' => 'Keep you hydrated',
            'long_description' => 'CodeBreak helps you drink liquids more often'
        ]);

        DB::table('habits')->insert([
            'type' => 'breathing',
            'short_description' => 'Breathing exercise',
            'long_description' => 'Turns out all you need is a pair of healthy lungs'
        ]);

        DB::table('habits')->insert([
            'type' => 'exercise',
            'short_description' => 'Stretching after coding',
            'long_description' => 'CodeBreak helps you relax after some coding hours'
        ]);
    }
}
