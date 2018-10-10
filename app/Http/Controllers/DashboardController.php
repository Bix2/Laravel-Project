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
            $data['user'] = $me;
            $data['habits'] = $habits;
            $data['userhabits'] = $userhabits;
            $data['api'] = $api;
            return view('dashboard', $data);
        }
    }
    
}
