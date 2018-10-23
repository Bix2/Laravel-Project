<?php

namespace App\Http\Controllers;

use App\Http\CodeBreak\FitBit;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\ClientInterface;
use brulath\fitbit\FitbitPHPOAuth2;
use brulath\fitbit\FitbitUser;
use brulath\fitbit\FitbitProvider;
use Illuminate\Http\Request;
use App\User;
use Auth;

class FitbitApiController extends Controller {

    protected function index() {  
        if (Auth::check()) { 
            $me = Auth::user();
            $habits = \DB::table('habits')->get();
            $userhabit = Auth::user()->habits->first();

            if ($userhabit) {
                // BASE 
                $client = new Client([
                    "base_uri" => "https://api.fitbit.com/1.2/",
                ]);

                // steps
                $habit['steps'] = $client->get("user/-/activities/steps/date/today/1w.json", [
                    "headers" => [
                        "Authorization" => "Bearer {$me->token}"
                    ]
                ]);
                // sleep
                $shabit['sleep'] = $client->get("user/-/sleep/list.json?offset=7&limit=7&sort=desc&beforeDate=today", [
                    "headers" => [
                        "Authorization" => "Bearer {$me->token}"
                    ]
                ]);
                // water
                $shabit['water'] = $client->get("user/-/foods/log/water/date/today/1w.json", [
                    "headers" => [
                        "Authorization" => "Bearer {$me->token}"
                    ]
                ]);

                return json_decode($habit->getBody(), true);
                print_r($habit);
            }

            $data['user'] = $me;
            // get all habits
            $data['habits'] = $habits;
            // get habit tracked by user
            $data['userhabit'] = $userhabit;
            return view('dashboard', $data);
        }
    }

    public static function showSteps() {
        $data = FitBit::getActivitySteps();
        // insert to database just for testing
        FitBit::insertStepsToDB($data);
    }

    public static function showSleep() {
        return FitBit::getSleepPattern();
    }
   
    public static function showWater() {
        return FitBit::getWaterLog();
    }
  
    public static function showProfile() {
        $data = FitBit::getProfileInfo();
        return view('profile', $data);
    }

    public static function getSleepGoal() {
        // return sleep goal in minutes
        return FitBit::getSleepPatternGoal();
    }

    public static function getActivityGoal() {
        return FitBit::getActivityStepsGoal();
    }

    public static function getWaterGoal() {
        return FitBit::getWaterLogGoal();
    }

    public function getstats() {
        // get current steps
        $me = Auth::user();
        $currentdate = date("Y-m-d");
        $usersteps = \DB::table('activitylogs')->where('user_id', $me->id)->where('date', $currentdate)->get();
        $totalsteps = 0;
        foreach ($usersteps as $userstep) {
            if($userstep->steps > $totalsteps){
                $totalsteps = $userstep->steps;
            }
            
        }

        // get goal
        $stepsgoal = 0;
        $usergoals = \DB::table('habit_user')->where('user_id', $me->id)->get();
        foreach ($usergoals as $usergoal) {
            if($usergoal->habit_id == 4) {
                $stepsgoal = $usergoal->goal;
            }
        }

        $response = [
            "userName"          =>      $me->name,
            "userAvatar"        =>      $me->avatar,
            "currentDate"       =>      $currentdate,
            "totalSteps"        =>      $totalsteps,
            "stepsGoal"         =>      $stepsgoal
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

}
