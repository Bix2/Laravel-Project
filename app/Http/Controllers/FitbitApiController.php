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

}
