<?php

namespace App\Http\Controllers;

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
        if (Auth::check()) { 
           $me = Auth::user();
    
           $client = new Client([
               "base_uri" => "https://api.fitbit.com/1.2/",
           ]);
    
           $response = $client->get("user/-/activities/steps/date/today/1d.json", [
               "headers" => [
                   "Authorization" => "Bearer {$me->token}"
               ]
           ]);
    
           $steps = json_decode($response->getBody(), true);
        //    print_r( $steps);
           $stepsvalue = $steps['activities-steps'][0]['value'];
           $stepsdate = $steps['activities-steps'][0]['dateTime'];
        //    $dateCheck = \DB::table('activitylogs')->where([['user_id', $me->id], ['date', $stepsdate]])->first();
        //    if( $dateCheck ) {
        //     \DB::table('activitylogs')->where([['user_id', $me->id], ['date', $stepsdate]])->update(['steps' => $stepsvalue]);
        //    } else {
            \DB::table('activitylogs')->insert([
                ['date' => $stepsdate, 'steps' => $stepsvalue,  'user_id' => $me->id]
            ]);
        //    }
           
            
       }
    }

    public function showSleep() {
        if (Auth::check()) { 
           $me = Auth::user();
   
           $client = new Client([
               "base_uri" => "https://api.fitbit.com/1.2/",
           ]);

         $response = $client->get("user/-/sleep/list.json?offset=7&limit=7&sort=desc&beforeDate=today", [
               "headers" => [
                   "Authorization" => "Bearer {$me->token}"
               ]
           ]);

           $sleep = json_decode($response->getBody(), true);
           print_r( $sleep);
       }
   }
   
   public function showWater() {
        if (Auth::check()) { 
            $me = Auth::user();

            $client = new Client([
                "base_uri" => "https://api.fitbit.com/1.2/",
            ]);

            $response = $client->get("user/-/foods/log/water/date/today/1w.json", [
                "headers" => [
                    "Authorization" => "Bearer {$me->token}"
                ]
            ]);

            $water = json_decode($response->getBody(), true);
            print_r( $water);
        }
    }
  
    public function showProfile() {
        if (Auth::check()) { 
            $me = Auth::user();
 
            $client = new Client([
                "base_uri" => "https://api.fitbit.com/1.2/",
            ]);

            $response = $client->get("user/-/profile.json", [
                "headers" => [
                    "Authorization" => "Bearer {$me->token}"
                ]
            ]);

            $profile = json_decode($response->getBody(), true);
            $data['profile']=$profile;
            print_r($data);
            return view('profile', $data);
        }
    }

    public static function getSleepGoal() {
        if (Auth::check()) { 
            $me = Auth::user();
 
            $client = new Client([
                "base_uri" => "https://api.fitbit.com/1.2/",
            ]);

            $response = $client->get("user/-/sleep/goal.json", [
                "headers" => [
                    "Authorization" => "Bearer {$me->token}"
                ]
            ]);

            $sleepGoal = json_decode($response->getBody(), true);
            return $sleepGoal['goal']['minDuration'];
        }
    }

    public static function getActivityGoal() {
        if (Auth::check()) { 
            $me = Auth::user();
 
            $client = new Client([
                "base_uri" => "https://api.fitbit.com/1.2/",
            ]);

            $response = $client->get("user/-/activities/goals/daily.json", [
                "headers" => [
                    "Authorization" => "Bearer {$me->token}"
                ]
            ]);

            $activityGoal = json_decode($response->getBody(), true);
            return $activityGoal['goals']['steps'];
        }
    }

    public static function getWaterGoal() {
        if (Auth::check()) { 
            $me = Auth::user();
 
            $client = new Client([
                "base_uri" => "https://api.fitbit.com/1.2/",
            ]);

            $response = $client->get("user/-/foods/log/water/goal.json", [
                "headers" => [
                    "Authorization" => "Bearer {$me->token}"
                ]
            ]);

            $waterGoal = json_decode($response->getBody(), true);
            return $waterGoal['goal']['goal'];
        }
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
