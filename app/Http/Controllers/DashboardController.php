<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\ClientInterface;
use SocialiteProviders\Manager\SocialiteWasCalled;
use App\User;
use Socialite;
use Auth;

class DashboardController extends Controller
{

    public function checkIfHabitsAreTracked() {
        // check if user is loggedin
        if (Auth::check()) { 
            // save user data to variable $me
            $me = Auth::user();
            // get many to many relation between habits en users tables
            $userHabitData = \App\User::where('id', $me->id)->with('habits')->first();
            // get habits table
            $habits = \DB::table('habits')->get();
            // check if the user is tracking some habits
            $userHabits = $userHabitData->habits;
            if(!($userHabits->isEmpty())) {
                // push data with active habits
                foreach ($userHabits as $userHabit) {
                    if ($userHabit->pivot->habit_id == 1) {
                        $data['activeHabits'][$userHabit->type] = $this->showSleep();
                    } elseif ($userHabit->pivot->habit_id == 2) {
                        $data['activeHabits'][$userHabit->type] = $this->showWater();
                    } elseif ($userHabit->pivot->habit_id == 3) {
                        $data['activeHabits'][$userHabit->type] = [
                            'type' => "breathing",
                            'title' => "Breathing track"
                        ];
                    } elseif ($userHabit->pivot->habit_id == 4) {
                        $data['activeHabits'][$userHabit->type] = [
                            'type' => "exercise",
                            'title' => "Exercise track"
                        ];
                    }
                }
                
                // push data with inactive habits
                foreach ($habits as $habit) {
                    if(empty($data['activeHabits'][$habit->type])) {
                        $data['inactiveHabits'][$habit->type] = ['title' => $habit->type];
                    }
                }
            } else {
                $data['inactiveHabits']['sleep'] = ['title' => 'sleep'];
                $data['inactiveHabits']['water'] = ['title' => 'water'];
                $data['inactiveHabits']['breathing'] = ['title' => 'breathing'];
                $data['inactiveHabits']['exercise'] = ['title' => 'exercise'];
            }
            
            $data['user'] = $me;
            // return dd($data);
            return view('dashboard', $data);
        }
    }

    public function showSleep() {
        // current logged in user
        if (Auth::check()) { 
            $me = Auth::user();
    
            $client = new Client([
                "base_uri" => "https://api.fitbit.com/1.2/",
            ]);

            $response = $client->get("user/-/sleep/date/today.json", [
                "headers" => [
                    "Authorization" => "Bearer {$me->token}"
                ]
            ]);

            $sleep = json_decode($response->getBody(), true);
            $sleep['type'] = 'sleep';
            $sleep['title'] = 'Sleep Tracking';
            return $sleep;
        }
    }

    public function showWater() {
        // current logged in user
        if (Auth::check()) { 
            $me = Auth::user();
    
            $client = new Client([
                "base_uri" => "https://api.fitbit.com/1.2/",
            ]);

            $response = $client->get("user/-/foods/log/water/date/today.json", [
                "headers" => [
                    "Authorization" => "Bearer {$me->token}"
                ]
            ]);

            $water = json_decode($response->getBody(), true);
            $water['type'] = 'water';
            $water['title'] = 'Water Tracking';
            return $water;
        }
    }

    public function showActivities() {
        // determine if a user is authenticated
        if (Auth::check()) { 
            // return the authenticated user
            $me = Auth::user();
    
            $client = new Client([
                "base_uri" => "https://api.fitbit.com/1/",
            ]);

            $response = $client->get("user/-/activities/date/today.json", [
                "headers" => [
                    "Authorization" => "Bearer {$me->token}"
                ]
            ]);

            $activities = json_decode($response->getBody(), true);
            print_r($activities);
            return view('dashboard');//->with(['steps' => $activities]);
        }
    }
    
}
