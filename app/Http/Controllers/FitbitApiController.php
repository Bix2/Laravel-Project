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

    public function showSteps() {
        if (Auth::check()) { 
           $me = Auth::user();
    
           $client = new Client([
               "base_uri" => "https://api.fitbit.com/1.2/",
           ]);
    
           $response = $client->get("user/-/activities/steps/date/today/1w.json", [
               "headers" => [
                   "Authorization" => "Bearer {$me->token}"
               ]
           ]);
    
           $steps = json_decode($response->getBody(), true);
           print_r( $steps);
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
                "base_uri" => "https://api.fitbit.com/1/",
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

}
