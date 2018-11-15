<?php

use Faker\Generator as Faker;

$factory->define(\App\Breathing::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTimeBetween($startDate = '-7 days', $endDate = 'now')->format("Y-m-d"),
        'amount' => rand(1, 3),
        'user_id' =>  rand(1, 10),
    ];
});
