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
            $fitbit = new FitbitPHPOAuth2(
                '22D8C4',
                '1af060bab766acb1396c7f43a2144c4c',
                'http://homestead.test/login/fitbit/callback',
                ['activity', 'heartrate', 'location', 'nutrition', 'profile', 'settings', 'sleep', 'social', 'weight'], true
            );
            
            // A session is required to prevent CSRF
            //session_start();
            
            $token = $fitbit->getToken();
            $refresh_token = $fitbit->getRefreshToken();
            $access_token = $fitbit->getAccessToken();
            $profile = $fitbit->getProfile();
            print_r([$profile, $token]);

           /* if ($user = User::where('fitbit_id', $encodedId)->first()) { 
                return $user;
            };
            //storeAccessTokenAsJsonInMyDatabase($access_token);
           // return redirect()->intended('/dashboard');*/
    }

    public function showSteps() {
        // current logged in user
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
        // current logged in user
        if (Auth::check()) { 
           $me = Auth::user();
   
           $client = new Client([
               "base_uri" => "https://api.fitbit.com/1.2/",
           ]);

       //$response = $client->get("user/-/activities/steps/date/today/1m.json", [
       //$response = $client->get("user/-/foods/log/water/date/today/1m.json", [
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
        // current logged in user
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
        // determine if a user is authenticated
        if (Auth::check()) { 
            // return the authenticated user
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
            print_r($profile);
        
        }
    }

}
