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

    public function index() {
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
            $api = new FitbitApiController();
            if(!($userHabits->isEmpty())) {
                // push data with active habits
                foreach ($userHabits as $userHabit) {
                    if ($userHabit->pivot->habit_id == 1) {
                        $data['activeHabits'][$userHabit->type] = $api->showSleep();
                        $data['activeHabits'][$userHabit->type]['info'] = \DB::table('habits')->where('type', $userHabit->type)->get();
                    } elseif ($userHabit->pivot->habit_id == 2) {
                        $data['activeHabits'][$userHabit->type] = $api->showWater();
                        $data['activeHabits'][$userHabit->type]['info'] = \DB::table('habits')->where('type', $userHabit->type)->get();
                    } elseif ($userHabit->pivot->habit_id == 3) {
                        $data['activeHabits'][$userHabit->type] = [
                            'type' => "breathing",
                            'title' => "Breathing track"
                        ];
                        $data['activeHabits'][$userHabit->type]['info'] = \DB::table('habits')->where('type', $userHabit->type)->get();
                    } elseif ($userHabit->pivot->habit_id == 4) {
                        $data['activeHabits'][$userHabit->type] = $api->showSteps();
                        $data['activeHabits'][$userHabit->type]['info'] = \DB::table('habits')->where('type', $userHabit->type)->get();
                    }
                }
                
                // push data with inactive habits
                foreach ($habits as $habit) {
                    if(empty($data['activeHabits'][$habit->type])) {
                        $data['inactiveHabits'][$habit->type]['info'] = \DB::table('habits')->where('type', $habit->type)->get();
                    }
                }
            } else {
                $data['inactiveHabits']['sleep']['info'] = \DB::table('habits')->where('type', 'sleep')->get();
                $data['inactiveHabits']['water']['info'] = \DB::table('habits')->where('type', 'water')->get();
                $data['inactiveHabits']['breathing']['info'] = \DB::table('habits')->where('type', 'breathing')->get();
                $data['inactiveHabits']['exercise']['info'] = \DB::table('habits')->where('type', 'exercise')->get();
            }
            
            $data['user'] = $me;
            // return dd($data);
            return view('dashboard', $data);
        }
    }
    
}
