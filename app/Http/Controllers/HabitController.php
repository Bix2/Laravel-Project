<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Habit;


class HabitController extends Controller
{
    // public function show($habit) {
    //     $data = Habit::getTrackedHabitInfo($habit);
    //     // TESTING: add data from steps activity (it should add the data from the actual habit instead)
    //     $data['stepsweek'] = Habit::getTrackedActivityStepsData();

    //     return view('habit', $data);
    // }

    public function show($habit) {
        $data = Habit::getTrackedHabitInfo($habit);
        $habitId = $data["habit"]->id;
        if($habitId == 1) {
            $data['sleepweek'] = Habit::getTrackedSleepLogsData();
        } else if($habitId == 2) {
            $data['waterweek'] = Habit::getTrackedWaterLogsData();
        } else if($habitId == 4) {
            $data['stepsweek'] = Habit::getTrackedActivityStepsData();
        }
        // TESTING: add data from steps activity (it should add the data from the actual habit instead)
        
        
        return view('habit', $data);
    }

    public function track($habit) {
        $data = Habit::trackHabit($habit);
        // TESTING: add data from steps activity (it should add the data from the actual habit instead)
        if($habitId == 2) {
            $data['waterweek'] = Habit::getTrackedWaterLogsData();
        } else if($habitId == 4) {
            $data['stepsweek'] = Habit::getTrackedActivityStepsData();
        }
        return view('habit', $data);
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