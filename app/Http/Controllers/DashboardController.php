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
            // get all habits
            $habits = \DB::table('habits')->get();
            // get habit tracked by user
            $userhabits = Auth::user()->habits->first();
            if ($userhabits) { 
                $userhabits = $userhabits->pivot->pivotParent->habits;
            }
            
            // summon api controller
            $api = new FitbitApiController();
/*
            foreach($userhabits as $habit) {
                if ($me->habits()->where('habit_id', '1')->get()) {
                   $data['sleep'] = $api->showSleep();
                if ($me->habits()->where('habit_id', '2')->get()) {
                    $data['water'] = $api->showWater();
                if ($me->habits()->where('habit_id', '4')->get()) {
                    $data['steps'] = $api->showSteps());
                } elseif ($me->habits()->where('habit_id', '3')->get()) {
                    echo('hello');
                }
            }




*/ 
$currentdate = date("Y-m-d");
$usersteps = \DB::table('activitylogs')->where('user_id', $me->id)->where('date', $currentdate)->get();
$totalsteps = 0;
foreach ($usersteps as $userstep) {
    if($userstep->steps > $totalsteps){
        $totalsteps = $userstep->steps;
    }
    
}

// dd($totalsteps);
$stepsgoal = 0;

$usergoals = \DB::table('habit_user')->where('user_id', $me->id)->get();
foreach ($usergoals as $usergoal) {
    if($usergoal->habit_id == 4) {
        $stepsgoal = $usergoal->goal;
    }
}










    $trackedhabits = [];
    $untrackedhabits = [];
    

            foreach ($habits as $habit){
                $habitCheck = -1;
                if($userhabits){
                    foreach($userhabits as $userhabit) {
                        if ($userhabit->getOriginal('pivot_habit_id') == ($habit->id) ) {
                            $habitCheck =  $habit->id;
                        }
                    }
                }
                if( $habitCheck > -1) {
                    array_push($trackedhabits, $habit);
                } else {
                    array_push($untrackedhabits, $habit);
                }
            }



            $data['trackedhabits'] = $trackedhabits;
            $data['untrackedhabits'] = $untrackedhabits;
            $data['user'] = $me;
            $data['habits'] = $habits;
            $data['userhabits'] = $userhabits;
            $data['totalsteps'] = $totalsteps;
            $data['stepsgoal'] = $stepsgoal;
            $data['api'] = $api;
            return view('dashboard', $data);
        }
    }

    // public function checkDailyGoals($userId, $date) {
    //     dd(date('d-m-Y'));
    //     \DB::table('habit_user')->insert([
    //         'habit_id' => $thishabit->id, 
    //         'user_id' => $me->id,
    //         'goal' => $goal
    //     ]);
    //     $data['button'] = ["text" => "Stop tracking this habit"];
    // }
    
}
