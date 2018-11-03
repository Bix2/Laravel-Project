<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Habit;
use App\Http\CodeBreak\Stats;


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
        } else if($habitId == 3) {
            $data['breathingweek'] = Habit::getTrackedBreathingData();
        } else if($habitId == 4) {
            $data['stepsweek'] = Habit::getTrackedActivityStepsData();
        }
        // TESTING: add data from steps activity (it should add the data from the actual habit instead)
        $data['trackedHabits'] = User::getTrackedAndUntrackedHabits();
        
        return view('habit', $data);
    }

    public function track($habit) {
        $data = Habit::trackHabit($habit);
        // TESTING: add data from steps activity (it should add the data from the actual habit instead)
        return redirect('/dashboard/'.$habit);
    }

    public function showbreath($habit) {
        $data = Habit::getTrackedHabitInfo($habit);
    //     $habitId = $data["habit"]->id;
    //     if($habitId == 1) {
    //         $data['sleepweek'] = Habit::getTrackedSleepLogsData();
    //     } else if($habitId == 2) {
    //         $data['waterweek'] = Habit::getTrackedWaterLogsData();
    //     } else if($habitId == 4) {
    //         $data['stepsweek'] = Habit::getTrackedActivityStepsData();
    //     }
    //     // TESTING: add data from steps activity (it should add the data from the actual habit instead)
        
        
        return view('breathsession', $data);
    }

    public function trackbreath(Request $request) {
        Habit::saveBreathTracked($request);
    }
    

    public function getDaily() {
        $data = Stats::getDailyTracked();
        return view('welcome', $data);
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