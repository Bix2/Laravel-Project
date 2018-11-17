<?php

use Faker\Generator as Faker;

$factory->define(\App\Activitylogs::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTimeBetween($startDate = '-7 days', $endDate = 'now')->format("Y-m-d"),
        'steps' => rand(0, 15000),
        'user_id' =>  rand(1, 10),
    ];
});
