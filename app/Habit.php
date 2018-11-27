<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\CodeBreak\FitBit;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\ClientInterface;
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
                $data['button'] = [
                    "text"      =>  "Remove this habit from the dashboard",
                    "status"    =>  "danger"
                ];
            } else {
                $data['button'] = [
                    "text"      =>  "Add this habit to your dashboard",
                    "status"    =>  "success"
                ];
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

            $stepsdata = [];
            $stepstotal = 0;
            foreach ($stepsweek as $st) {
                $stepstotal = $stepstotal + $st;
            }
            $stepsdata['stepsweek'] = $stepsweek;
            $stepsdata['stepstotal'] = $stepstotal;

            return $stepsdata;
        }
    }

    public static function getTrackedWaterLogsData() {
        if (Auth::check()) { 
            $me = Auth::user();
            $waterlogs = \DB::table('waterlogs')->where('user_id', $me->id)->get();
                
            $waterweek = [];

            for ($d = -6; $d <= 0; $d++) {
                $date = date('Y-m-d', strtotime($d.' days'));
                $amount = 0;
                foreach ($waterlogs as $waterlog) {
                    if($waterlog->date == $date && $waterlog->amount > $amount){
                        $amount = $waterlog->amount;
                    }
                }
                array_push($waterweek, $amount);
            } 
            $waterdata = [];
            $watertotal = 0;
            foreach ($waterweek as $w) {
                $watertotal = $watertotal + $w;
            }
            $waterdata['waterweek'] = $waterweek;
            $waterdata['watertotal'] = $watertotal;

            return $waterdata;
        }
    }

    public static function getTrackedBreathingData() {
        if (Auth::check()) { 
            $me = Auth::user();
            $breathinglogs = \DB::table('breathing')->where('user_id', $me->id)->get();
                
            $breathingweek = [];

            for ($d = -6; $d <= 0; $d++) {
                $date = date('Y-m-d', strtotime($d.' days'));
                $amount = 0;
                foreach ($breathinglogs as $breathinglog) {
                    if( strpos($breathinglog->date, $date) === 0){
                        $amount = $breathinglog->amount + $amount;
                    }
                }
                array_push($breathingweek, $amount);
            } 

            $breathingdata = [];
            $breathingtotal = 0;
            foreach ($breathingweek as $b) {
                $breathingtotal = $breathingtotal + $b;
            }
            $breathingdata['breathingweek'] = $breathingweek;
            $breathingdata['breathingtotal'] = $breathingtotal;

            return $breathingdata;
        }
    }


    public static function getTrackedSleepLogsData() {
        if (Auth::check()) { 
            $me = Auth::user();
            $sleeplogs = \DB::table('sleeplogs')->where('user_id', $me->id)->get();
                
            $sleepweek = [];
            $sleepweek["deep_minutes"] = [];
            $sleepweek["light_minutes"] = [];
            $sleepweek["rem_minutes"] = [];
            $sleepweek["wake_minutes"] = [];

            for ($d = -6; $d <= 0; $d++) {
                $date = date('Y-m-d', strtotime($d.' days'));
                $deep_minutes = 0;
                $light_minutes = 0;
                $rem_minutes = 0;
                $wake_minutes = 0;
                foreach ($sleeplogs as $sleeplog) {
                    if($sleeplog->date_of_sleep == $date && $sleeplog->deep_minutes >= $deep_minutes && $sleeplog->light_minutes >= $light_minutes && $sleeplog->rem_minutes >= $rem_minutes && $sleeplog->wake_minutes >= $wake_minutes){
                        $deep_minutes = $sleeplog->deep_minutes;
                        $light_minutes = $sleeplog->light_minutes;
                        $rem_minutes = $sleeplog->rem_minutes;
                        $wake_minutes = $sleeplog->wake_minutes;
                    }
                }
                array_push($sleepweek["deep_minutes"], $deep_minutes);
                array_push($sleepweek["light_minutes"], $light_minutes);
                array_push($sleepweek["rem_minutes"], $rem_minutes);
                array_push($sleepweek["wake_minutes"], $wake_minutes);
            } 
        
            $sleepdata = [];
            $sleeptotal = 0;
            foreach ($sleepweek as $sl) {
                foreach ($sl as $mins) {
                    $sleeptotal = $sleeptotal + $mins;
                }
            }

            $sleepdata['sleepweek'] = $sleepweek;
            $sleepdata['sleeptotal'] = $sleeptotal;

            return $sleepdata;
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
                $data['button'] = [
                    "text"      =>  "Add this habit to your dashboard",
                    "status"    =>  "success"
                ];
            } else {
                // this can be done better but is ok like that for now
                if($thishabit->id == 1) {
                    $goal = FitBit::getSleepPatternGoal();
                } elseif ($thishabit->id == 4) {
                    $goal = FitBit::getWaterLogGoal();
                } elseif ($thishabit->id == 2) {
                    // static data for now
                    $goal = 5;
                } elseif ($thishabit->id == 3) {
                    $goal = FitBit::getActivityStepsGoal();
                }
                \DB::table('habit_user')->insert([
                    'habit_id' => $thishabit->id, 
                    'user_id' => $me->id,
                    'goal' => $goal
                ]);
                $data['button'] = [
                    "text"      =>  "Remove this habit from the dashboard",
                    "status"    =>  "danger"
                ];
            }

            $data['user'] = $me;
            $data['habit'] = $thishabit;
            $data['userhabits'] = $userhabits;

            return $data;
        }
    }
    public static function saveBreathTracked(Request $request) {
        $amount = $request->input('amount');
        if (Auth::check()) {
            $userId = Auth::user()->id;
            \DB::table('breathing')->insert([
                'user_id' => $userId,
                'amount' => $amount,
                'date' => date('Y-m-d'),
            ]);
        }
    }

    public static function AddWaterLog($request) {
        $client = new Client();
        $amount = $request["amount"];
        if($amount == null){
            $amount = 0;
        }

        if( is_numeric($amount) ) {
        } else {
            $amount = 0;
        }

        $date = date('Y-m-d');
        $formdata = [
            'amount' => $amount,
            'date' => $date,
            'unit' => 'ml'
        ];
        if (Auth::check()) {
            $me = Auth::user();
            $water = $client->post("https://api.fitbit.com/1.2/user/{$me->fitbit_id}/foods/log/water/water.json", [
                "headers" => [
                    "Authorization" => "Bearer {$me->token}",
                ],
                "form_params" => $formdata
            ]);
        }
        
        return $water;
    }


    // Get the water goal of the user from FitBit API
    public static function getBreathingGoal() {
        if (Auth::check()) { 
            $me = Auth::user();
            $breathingGoal = \DB::table('habit_user')->where([['user_id', $me->id], ['habit_id', 2]])->first();
            return $breathingGoal->goal;
        }
    }

    public function users() {
        return $this->belongsToMany('\App\User');
    }
}
