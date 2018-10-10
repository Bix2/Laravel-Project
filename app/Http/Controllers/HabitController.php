<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Habit;


class HabitController extends Controller
{
    public function show($habit) {
        if (Auth::check()) { 
            // save user data to variable $me
            $me = Auth::user();
            // get habit tracked by user
            $thishabit = \DB::table('habits')->where('type', $habit)->first();
            $tracked_habit = $this->isTracked($thishabit->id, $me->id);

            if($tracked_habit) {
                $data['button'] = ["text" => "Stop tracking this habit"];
            } else {
                $data['button'] = ["text" => "Track this habit"];
            }

            $data['user'] = $me;
            $data['habit'] = $thishabit;
            $data['tracked_habit'] = $tracked_habit;
            return view('habit', $data);
        }
     
    }

    public function track($habit) {
        if (Auth::check()) { 
            // save user data to variable $me
            $me = Auth::user();
            // get all habits
            $habits = \DB::table('habits')->get();
            // get habit tracked by user
            $userhabits = Auth::user()->habits->first();

            $thishabit = \DB::table('habits')->where('type', $habit)->first();
            $tracked_habit = $this->isTracked($thishabit->id, $me->id);

            if($tracked_habit) {
                \DB::table('habit_user')->where([
                    ['habit_id', '=', $thishabit->id],
                    ['user_id', '=', $me->id]
                ])->delete();
                $data['button'] = ["text" => "Track this habit"];
            } else {
                // this can be done better but is ok like that for now
                if($thishabit->id == 1) {
                    $goal = FitbitApiController::getSleepGoal();
                } elseif ($thishabit->id == 2) {
                    $goal = FitbitApiController::getWaterGoal();
                } elseif ($thishabit->id == 3) {
                    // static data for now
                    $goal = 3;
                } elseif ($thishabit->id == 4) {
                    $goal = FitbitApiController::getActivityGoal();
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
            return view('habit', $data);
        }
    }

    public function isTracked($habitId, $userId) {
        $tracked_habit = \DB::table('habit_user')->where([
            ['habit_id', '=', $habitId],
            ['user_id', '=', $userId]
        ])->first();
        return !empty($tracked_habit);
    }

    /*

    public function show($habitType, Request $request){
        $habits = Habit::with('habit_id')
                ->whereHas('habit_id', function($query) use $habitType {
                    $query->where('habit_type', $habitType); 
                }->get(); 
    
        return $habits;
    }

    */

}