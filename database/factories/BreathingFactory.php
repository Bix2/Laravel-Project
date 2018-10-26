<?php

use Faker\Generator as Faker;

$factory->define(\App\Breathing::class, function (Faker $faker) {
    return [
        'time' => $faker->dateTimeBetween($startDate = '-7 days', $endDate = 'now'),
        'amount' => rand(1, 3),
        'user_id' =>  rand(1, 10),
    ];
});
