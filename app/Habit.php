<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\CodeBreak\FitBit;
use Auth;
use App\User;

class Habit extends Model
{   
    public static function getTrackedHabitInfo($habit) {
        if (Auth::check()) { 
            // save user data to variable $me
            $me = Auth::user();
            // get habit tracked by user
            $thishabit = \DB::table('habits')->where('type', $habit)->first();
            $tracked_habit = Habit::isTracked($thishabit->id, $me->id);

            if($tracked_habit) {
                $data['button'] = ["text" => "Stop tracking this habit"];
            } else {
                $data['button'] = ["text" => "Track this habit"];
            }

            $data['user'] = $me;
            $data['habit'] = $thishabit;
            $data['tracked_habit'] = $tracked_habit;

            return $data;
        }
    }

    private static function isTracked($habitId, $userId) {
        $tracked_habit = \DB::table('habit_user')->where([
            ['habit_id', '=', $habitId],
            ['user_id', '=', $userId]
        ])->first();
        return !empty($tracked_habit);
    }

    public static function getTrackedActivityStepsData() {
        if (Auth::check()) { 
            $me = Auth::user();
            $usersteps = \DB::table('activitylogs')->where('user_id', $me->id)->get();
                
            $stepsweek = [];

            for ($d = -6; $d <= 0; $d++) {
                $date = date('Y-m-d', strtotime($d.' days'));
                $steps = 0;
                foreach ($usersteps as $userstep) {
                    if($userstep->date == $date && $userstep->steps > $steps){
                        $steps = $userstep->steps;
                    }
                }
                array_push($stepsweek, $steps);
            } 

            return $stepsweek;
        }
    }

    public static function trackHabit($habit) {
        if (Auth::check()) { 
            // save user data to variable $me
            $me = Auth::user();
            // get all habits
            $habits = \DB::table('habits')->get();
            // get habit tracked by user
            $userhabits = Auth::user()->habits->first();

            $thishabit = \DB::table('habits')->where('type', $habit)->first();
            $tracked_habit = Habit::isTracked($thishabit->id, $me->id);

            if($tracked_habit) {
                \DB::table('habit_user')->where([
                    ['habit_id', '=', $thishabit->id],
                    ['user_id', '=', $me->id]
                ])->delete();
                $data['button'] = ["text" => "Track this habit"];
            } else {
                // this can be done better but is ok like that for now
                if($thishabit->id == 1) {
                    $goal = FitBit::getSleepPatternGoal();
                } elseif ($thishabit->id == 2) {
                    $goal = FitBit::getWaterLogGoal();
                } elseif ($thishabit->id == 3) {
                    // static data for now
                    $goal = 3;
                } elseif ($thishabit->id == 4) {
                    $goal = FitBit::getActivityStepsGoal();
                }
                \DB::table('habit_user')->insert([
                    'habit_id' => $thishabit->id, 
                    'user_id' => $me->id,
                    'goal' => $goal
                ]);
                $data['button'] = ["text" => "Stop tracking this habit"];
            }

            $data['user'] = $me;
            $data['habit'] = $thishabit;
            $data['userhabits'] = $userhabits;

            return $data;
        }
    }

    public function users() {
        return $this->belongsToMany('\App\User');
    }
}
