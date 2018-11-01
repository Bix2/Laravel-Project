<?php

namespace App\Http\CodeBreak;


class Stats {

   public static function getDailyTracked(){
        $date = date('Y-m-d');
        $deep_minutes = \DB::table('sleeplogs')->where('date_of_sleep', $date)->sum('deep_minutes');
        $light_minutes = \DB::table('sleeplogs')->where('date_of_sleep', $date)->sum('light_minutes');
        $rem_minutes = \DB::table('sleeplogs')->where('date_of_sleep', $date)->sum('rem_minutes');
        $total_sleep = $deep_minutes + $light_minutes + $rem_minutes;

        $dailywater = \DB::table('waterlogs')->where('date', $date)->sum('amount');

        $dailybreathing = \DB::table('breathing')->where('date', 'like', $date.'%')->sum('amount');

        $dailysteps = \DB::table('activitylogs')->where('date', $date)->sum('steps');

        $data['total_sleep'] = $total_sleep;
        $data['deep_minutes'] = $deep_minutes;
        $data['light_minutes'] = $light_minutes;
        $data['rem_minutes'] = $rem_minutes;
        $data['dailywater'] = round($dailywater/1000);
        $data['dailybreathing'] = $dailybreathing;
        $data['dailysteps'] = $dailysteps;
        return $data;
   }

}