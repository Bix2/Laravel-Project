<?php

use Faker\Generator as Faker;

$factory->define(\App\Sleeplogs::class, function (Faker $faker) {
    return [
        'date_of_sleep' => $faker->dateTimeBetween($startDate = '-7 days', $endDate = 'now')->format("Y-m-d"),
        'deep_minutes' => rand(0, 360),
        'light_minutes' => rand(0, 360),
        'rem_minutes' => rand(0, 360),
        'wake_minutes' => rand(0, 360),
        'user_id' =>  rand(1, 10),
    ];
});
