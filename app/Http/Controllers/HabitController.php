<?php

namespace App\Http\Controllers;

use App\Http\CodeBreak\FitBit;
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
            $data['sleepdata'] = Habit::getTrackedSleepLogsData();
            $data['sleepgoal'] = FitBit::getSleepPatternGoal();
        } else if($habitId == 2) {
            $data['breathingdata'] = Habit::getTrackedBreathingData();
            // $data['breathinggoal'] = Habit::getBreathingGoal();
        } else if($habitId == 3) {
            $data['stepsdata'] = Habit::getTrackedActivityStepsData();
            $data['stepsgoal'] = FitBit::getActivityStepsGoal();
        } else if($habitId == 4) {
            $data['waterdata'] = Habit::getTrackedWaterLogsData();
            $data['watergoal'] = FitBit::getWaterLogGoal();
        }
        // TESTING: add data from steps activity (it should add the data from the actual habit instead)
        $data['trackedHabits'] = User::getTrackedAndUntrackedHabits();
        
        return view('habit', $data);
    }

    public function track($habit) {
        $data = Habit::trackHabit($habit);
        // TESTING: add data from steps activity (it should add the data from the actual habit instead)
        return redirect('dashboard');
    }

    public function showbreath($habit) {
        $data = Habit::getTrackedHabitInfo($habit);
        $data['trackedHabits'] = User::getTrackedAndUntrackedHabits();
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

    public function logActivity(Request $request) {

        $validatedData = $request->validate([
            'date'      =>  'required',
            'start'     =>  'required',
            'distance'  =>  'required',
            'duration'  =>  'required'
        ]);
        FitBit::logActivityToFitBit($request);
        $steps = FitBit::getActivitySteps();
        FitBit::insertStepsToDB($steps);
        return redirect('/dashboard/exercise')->with('status', 'You have successfully logged steps!');
    }

    public function changeActivityGoal(Request $request) {

        $validatedData = $request->validate([
            'goal'      =>  'required'
        ]);
        $goal = FitBit::logNewGoalActivity($request);
        Habit::changeActivityGoalInDB($goal);
        return redirect('/dashboard/exercise')->with('status', 'Activity goal has been updated!');
    }


    public function logWater(Request $request){
        $request["wateradd"] = $request["wateradd"]*1000;
        FitBit::AddWaterLog($request);
        $water = FitBit::getWaterLog();
        FitBit::insertWaterLogToDB($water);
        return redirect('/dashboard/water')->with('status', 'You have successfully logged water!');
    }

    public function changeWaterGoal(Request $request){
        $request["goaladd"] = $request["goaladd"]*1000;
        FitBit::ChangeWaterGoal($request);
        $goal = FitBit::getWaterLogGoal();
        Habit::changeWaterGoalInDB($goal);
        return redirect('/dashboard/water')->with('status', 'Water goal has been updated!');
    }

}