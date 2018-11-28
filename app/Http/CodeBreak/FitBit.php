<?php

namespace App\Http\CodeBreak;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\ClientInterface;
use brulath\fitbit\FitbitPHPOAuth2;
use brulath\fitbit\FitbitUser;
use brulath\fitbit\FitbitProvider;
use Illuminate\Http\Request;
use App\User;
use App\Habit;
use Auth;

class FitBit {

    // Get the daily steps of the user from FitBit API
    public static function getActivitySteps() {
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
            return $steps;
        }
    }

    // Get the weekly steps of the user from FitBit API
    public static function getActivityStepsWeek() {
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
            return $steps;
        }
    }

    // Get the steps goal of the user from FitBit API
    public static function getActivityStepsGoal() {
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

    // Get the daily sleep pattern of the user from FitBit API
    public static function getSleepPattern() {
        if (Auth::check()) { 
            $me = Auth::user();
    
            $client = new Client([
                "base_uri" => "https://api.fitbit.com/1.2/",
            ]);
                // https://api.fitbit.com/1.2/user/-/sleep/date/2017-04-02.json
          $response = $client->get("user/-/sleep/date/today.json", [
                "headers" => [
                    "Authorization" => "Bearer {$me->token}"
                ]
            ]);
            
            $sleep = json_decode($response->getBody(), true);
            return $sleep;
        }
    }

    // Get the weekly sleep pattern of the user from FitBit API
    public static function getSleepPatternWeek() {
        if (Auth::check()) { 
            $me = Auth::user();
    
            $client = new Client([
                "base_uri" => "https://api.fitbit.com/1.2/",
            ]);
                // https://api.fitbit.com/1.2/user/-/sleep/date/2017-04-02.json
            $sevenDaysAgo = date('Y-m-d', strtotime('-7 days'));
            $today = date('Y-m-d');
            $response = $client->get("user/-/sleep/date/".$sevenDaysAgo."/".$today.".json", [
                "headers" => [
                    "Authorization" => "Bearer {$me->token}"
                ]
            ]);
            
            $sleep = json_decode($response->getBody(), true);
            return $sleep;
        }
    }

    // Get the sleep goal of the user from FitBit API
    public static function getSleepPatternGoal() {
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

    // Get the water log of the user from FitBit API
    public static function getWaterLog() {
        if (Auth::check()) { 
            $me = Auth::user();

            $client = new Client([
                "base_uri" => "https://api.fitbit.com/1.2/",
            ]);

            $response = $client->get("user/-/foods/log/water/date/today/1d.json", [
                "headers" => [
                    "Authorization" => "Bearer {$me->token}"
                ]
            ]);

            $water = json_decode($response->getBody(), true);
            return $water;
        }
    }

    // Get the water log of the user from FitBit API
    public static function getWaterLogWeek() {
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
            return $water;
        }
    }

    // Get the water goal of the user from FitBit API
    public static function getWaterLogGoal() {
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

    public static function getProfileInfo() {
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
            $data['user'] = $me;
            $data['profile'] = $profile;
            return $data;
        }
    }

    public static function insertStepsToDB($steps) {
        if (Auth::check()) { 
            $me = Auth::user();
            $value = $steps['activities-steps'][0]['value'];
            $date = $steps['activities-steps'][0]['dateTime'];
            // check if user was already an record in the database on this date
            $dateCheck = \DB::table('activitylogs')->where([['user_id', $me->id], ['date', $date]])->first();
            if( $dateCheck ) {
                \DB::table('activitylogs')->where([['user_id', $me->id], ['date', $date]])->update(['steps' => $value]);
            } else {
                \DB::table('activitylogs')->insert([
                    ['date' => $date, 'steps' => $value,  'user_id' => $me->id]
                ]);
           }
        }
    }

    public static function insertStepsWeekToDB($steps) {
        if (Auth::check()) { 
            $me = Auth::user();
            foreach ($steps['activities-steps'] as $s) {
                $value = $s['value'];
                $date = $s['dateTime'];
                \DB::table('activitylogs')->insert([
                    ['date' => $date, 'steps' => $value,  'user_id' => $me->id]
                ]);
            }
        }
    }

    public static function insertSleepToDB($sleep) {
        if (Auth::check()) { 
            $me = Auth::user();
            $deep = 0;
            $light = 0;
            $rem = 0;
            $wake = 0;
            $date = date('Y-m-d');
            if(empty($sleep['sleep'])){

            } else if(!(array_key_exists("deep",$sleep['sleep'][0]['levels']['summary']))) {
                
            } else {
                $deep = $sleep['sleep'][0]['levels']['summary']['deep']['minutes'];
                $light = $sleep['sleep'][0]['levels']['summary']['light']['minutes'];
                $rem = $sleep['sleep'][0]['levels']['summary']['rem']['minutes'];
                $wake = $sleep['sleep'][0]['levels']['summary']['wake']['minutes'];
                $date = $sleep['sleep'][0]['dateOfSleep'];
            }

            // check if user was already an record in the database on this date
            $dateCheck = \DB::table('sleeplogs')->where([['user_id', $me->id], ['date_of_sleep', $date]])->first();
            if( $dateCheck ) {
                \DB::table('sleeplogs')->where([['user_id', $me->id], ['date_of_sleep', $date]])
                    ->update([
                        'deep_minutes'  =>  $deep,
                        'light_minutes' =>  $light,
                        'rem_minutes'   =>  $rem,
                        'wake_minutes'  =>  $wake
                    ]);
            } else {
                \DB::table('sleeplogs')->insert([
                    [   'date_of_sleep' => $date, 
                        'deep_minutes'  =>  $deep,
                        'light_minutes' =>  $light,
                        'rem_minutes'   =>  $rem,
                        'wake_minutes'  =>  $wake,
                        'user_id' => $me->id]
                ]);
           }
        }
    }

    public static function insertSleepWeekToDB($sleep) {
        if (Auth::check()) { 
            $me = Auth::user();

            if(empty($sleep['sleep'])) {
                // get the last seven days to populate with values
                $lastSevenDays = FitBit::getLastNDays(7, 'Y-m-d');
                foreach ($lastSevenDays as $day) {
                    $deep = 0;
                    $light = 0;
                    $rem = 0;
                    $wake = 0;
                    $date = date('Y-m-d');
                    \DB::table('sleeplogs')->insert([
                        [   'date_of_sleep' => $day, 
                            'deep_minutes'  =>  $deep,
                            'light_minutes' =>  $light,
                            'rem_minutes'   =>  $rem,
                            'wake_minutes'  =>  $wake,
                            'user_id' => $me->id]
                    ]);
                }
            } 
            
            foreach ($sleep['sleep'] as $s) {
                if(!(array_key_exists("deep",$s['levels']['summary']))) {
                    $deep = 0;
                    $light = 0;
                    $rem = 0;
                    $wake = 0;
                    $date = $s['dateOfSleep'];
                    \DB::table('sleeplogs')->insert([
                        [   'date_of_sleep' => $date, 
                            'deep_minutes'  =>  $deep,
                            'light_minutes' =>  $light,
                            'rem_minutes'   =>  $rem,
                            'wake_minutes'  =>  $wake,
                            'user_id' => $me->id]
                    ]);
                } else {
                    $deep = $s['levels']['summary']['deep']['minutes'];
                    $light = $s['levels']['summary']['light']['minutes'];
                    $rem = $s['levels']['summary']['rem']['minutes'];
                    $wake = $s['levels']['summary']['wake']['minutes'];
                    $date = $s['dateOfSleep'];
                    \DB::table('sleeplogs')->insert([
                        [   'date_of_sleep' => $date, 
                            'deep_minutes'  =>  $deep,
                            'light_minutes' =>  $light,
                            'rem_minutes'   =>  $rem,
                            'wake_minutes'  =>  $wake,
                            'user_id' => $me->id]
                    ]);
                }
            }
        }
    }

    public static function insertWaterLogToDB($water) {
        if (Auth::check()) { 
            $me = Auth::user();
            $value = $water['foods-log-water'][0]['value'];
            $date = $water['foods-log-water'][0]['dateTime'];
            // check if user was already an record in the database on this date
            $dateCheck = \DB::table('waterlogs')->where([['user_id', $me->id], ['date', $date]])->first();
            if( $dateCheck ) {
                \DB::table('waterlogs')->where([['user_id', $me->id], ['date', $date]])->update(['amount' => $value]);
            } else {
                \DB::table('waterlogs')->insert([
                    ['date' => $date, 'amount' => $value,  'user_id' => $me->id]
                ]);
           }
        }
    }

    public static function insertWaterLogWeekToDB($water) {
        if (Auth::check()) { 
            $me = Auth::user();

            foreach ($water['foods-log-water'] as $w) {
                $value = $w['value'];
                $date = $w['dateTime'];
                \DB::table('waterlogs')->insert([
                    ['date' => $date, 'amount' => $value,  'user_id' => $me->id]
                ]);
            }
        }
    }

    public static function getLastNDays($days, $format = 'd-m'){
        $m = date("m"); $de= date("d"); $y= date("Y");
        $dateArray = array();
        for($i=0; $i<=$days-1; $i++){
            $dateArray[] = date($format, mktime(0,0,0,$m,($de-$i),$y)); 
        }
        return array_reverse($dateArray);
    }

    // Steps habit automatization
    public static function AutomateSteps() {
        $users = \DB::table('users')->get();
        foreach ($users as $user) {

            // base64 encode client id and secret id
            $clientId = '22D8C4';
            $secretId = '1af060bab766acb1396c7f43a2144c4c';
            $base64CLientIdSecretId = base64_encode( $clientId.':'.$secretId );

            // refresh token
            $client = new Client([
                "base_uri" => "https://api.fitbit.com/oauth2/",
            ]);
            $response = $client->post("token", [
                "headers" => [
                    "Authorization" => "Basic {$base64CLientIdSecretId}",
                    "Content-Type"  => "application/x-www-form-urlencoded"
                ],
                "body"  =>  "grant_type=refresh_token&refresh_token={$user->remember_token}"
            ]);
            $data = json_decode($response->getBody(), true);

            // Update refresh user credentials
            \DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'remember_token'    =>  $data['refresh_token'],
                    'token'             =>  $data['access_token']
                ]);

            // Update Habit
            $client = new Client([
                "base_uri" => "https://api.fitbit.com/1.2/",
            ]);
            $response = $client->get("user/".$user->fitbit_id."/activities/steps/date/today/1d.json", [
                "headers" => [
                    "Authorization" => "Bearer {$user->token}"
                ]
            ]);
            $steps = json_decode($response->getBody(), true);
            $value = $steps['activities-steps'][0]['value'];
            $date = $steps['activities-steps'][0]['dateTime'];
            // check if user was already an record in the database on this date
            $dateCheck = \DB::table('activitylogs')->where([['user_id', $user->id], ['date', $date]])->first();
            if( $dateCheck ) {
                \DB::table('activitylogs')->where([['user_id', $user->id], ['date', $date]])->update(['steps' => $value]);
            } else {
                \DB::table('activitylogs')->insert([
                    ['date' => $date, 'steps' => $value,  'user_id' => $user->id]
                ]);
            }
        }
    }

    // Sleep habit automatization
    public static function AutomateSleep() {
        $users = \DB::table('users')->get();
        foreach ($users as $user) {

            // base64 encode client id and secret id
            $clientId = '22D8C4';
            $secretId = '1af060bab766acb1396c7f43a2144c4c';
            $base64CLientIdSecretId = base64_encode( $clientId.':'.$secretId );

            // refresh token
            $client = new Client([
                "base_uri" => "https://api.fitbit.com/oauth2/",
            ]);
            $response = $client->post("token", [
                "headers" => [
                    "Authorization" => "Basic {$base64CLientIdSecretId}",
                    "Content-Type"  => "application/x-www-form-urlencoded"
                ],
                "body"  =>  "grant_type=refresh_token&refresh_token={$user->remember_token}"
            ]);
            $data = json_decode($response->getBody(), true);

            // Update refresh user credentials
            \DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'remember_token'    =>  $data['refresh_token'],
                    'token'             =>  $data['access_token']
                ]);

            // Update Habit
            $client = new Client([
                "base_uri" => "https://api.fitbit.com/1.2/",
            ]);
            $response = $client->get("user/".$user->fitbit_id."/sleep/date/today.json", [
                "headers" => [
                    "Authorization" => "Bearer {$user->token}"
                ]
            ]);
            $sleep = json_decode($response->getBody(), true);

            $deep = 0;
            $light = 0;
            $rem = 0;
            $wake = 0;
            $date = date('Y-m-d');
            if(empty($sleep['sleep'])){

            } else if(!(array_key_exists("deep",$sleep['sleep'][0]['levels']['summary']))) {
                
            } else {
                $deep = $sleep['sleep'][0]['levels']['summary']['deep']['minutes'];
                $light = $sleep['sleep'][0]['levels']['summary']['light']['minutes'];
                $rem = $sleep['sleep'][0]['levels']['summary']['rem']['minutes'];
                $wake = $sleep['sleep'][0]['levels']['summary']['wake']['minutes'];
                $date = $sleep['sleep'][0]['dateOfSleep'];
            }

            // check if user was already an record in the database on this date
            $dateCheck = \DB::table('sleeplogs')->where([['user_id', $user->id], ['date_of_sleep', $date]])->first();
            if( $dateCheck ) {
                \DB::table('sleeplogs')->where([['user_id', $user->id], ['date_of_sleep', $date]])
                    ->update([
                        'deep_minutes'  =>  $deep,
                        'light_minutes' =>  $light,
                        'rem_minutes'   =>  $rem,
                        'wake_minutes'  =>  $wake
                    ]);
            } else {
                \DB::table('sleeplogs')->insert([
                    [   'date_of_sleep' => $date, 
                        'deep_minutes'  =>  $deep,
                        'light_minutes' =>  $light,
                        'rem_minutes'   =>  $rem,
                        'wake_minutes'  =>  $wake,
                        'user_id' => $user->id]
                ]);
            }
        }
    }

    // Steps habit automatization
    public static function AutomateWater() {
        $users = \DB::table('users')->get();
        foreach ($users as $user) {

            // base64 encode client id and secret id
            $clientId = '22D8C4';
            $secretId = '1af060bab766acb1396c7f43a2144c4c';
            $base64CLientIdSecretId = base64_encode( $clientId.':'.$secretId );

            // refresh token
            $client = new Client([
                "base_uri" => "https://api.fitbit.com/oauth2/",
            ]);
            $response = $client->post("token", [
                "headers" => [
                    "Authorization" => "Basic {$base64CLientIdSecretId}",
                    "Content-Type"  => "application/x-www-form-urlencoded"
                ],
                "body"  =>  "grant_type=refresh_token&refresh_token={$user->remember_token}"
            ]);
            $data = json_decode($response->getBody(), true);

            // Update refresh user credentials
            \DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'remember_token'    =>  $data['refresh_token'],
                    'token'             =>  $data['access_token']
                ]);

            // Update Habit
            $client = new Client([
                "base_uri" => "https://api.fitbit.com/1.2/",
            ]);
            $response = $client->get("user/".$user->fitbit_id."/foods/log/water/date/today/1d.json", [
                "headers" => [
                    "Authorization" => "Bearer {$user->token}"
                ]
            ]);
            $water = json_decode($response->getBody(), true);
            $value = $water['foods-log-water'][0]['value'];
            $date = $water['foods-log-water'][0]['dateTime'];
            // check if user was already an record in the database on this date
            $dateCheck = \DB::table('waterlogs')->where([['user_id', $user->id], ['date', $date]])->first();
            if( $dateCheck ) {
                \DB::table('waterlogs')->where([['user_id', $user->id], ['date', $date]])->update(['amount' => $value]);
            } else {
                \DB::table('waterlogs')->insert([
                    ['date' => $date, 'amount' => $value,  'user_id' => $user->id]
                ]);
            }
        }
    }

    public static function logActivityToFitBit($request) {
        if (Auth::check()) { 
            $me = Auth::user();

            // get value from inputs
            $date = $request->input('date');
            $startTime = $request->input('start');
            $distance = $request->input('distance');

            $duration = $request->input('duration');
            $durationInMilliseconds   = explode(":", $duration);
            $hour   = $durationInMilliseconds[0] * 60 * 60 * 1000;
            $minute = $durationInMilliseconds[1] * 60 * 1000;
            $durationInMilliseconds = $hour + $minute;

            $client = new Client([
                "base_uri" => "https://api.fitbit.com/",
            ]);
            $response = $client->post("1/user/-/activities.json", [
                "headers" => [
                    "Authorization"     =>  "Bearer {$me->token}",
                    "Accept-Language"   =>  "fr_FR"
                ],
                "form_params"  =>  [
                    "activityId"        =>  90013,
                    "startTime"         =>  $startTime,
                    "durationMillis"    =>  $durationInMilliseconds,
                    "date"              =>  $date,
                    "distance"          =>  $distance,
                ]
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
        if (Auth::check()) {
            $me = Auth::user();
            $water = $client->post("https://api.fitbit.com/1/user/-/foods/log/water.json", [
                "headers" => [
                    "Authorization" => "Bearer {$me->token}",
                ],
                "form_params" => [
                    'amount' => (int)$amount,
                    'date' => $date,
                    'unit' => 'ml'
                ]
            ]);
        }
    }

    public static function ChangeWaterGoal($request) {
        $client = new Client();
        $amount = $request["amount"];
        if($amount == null){
            $amount = 0;
        }

        if( is_numeric($amount) ) {
        } else {
            $amount = 0;
        }
        if (Auth::check()) {
            $me = Auth::user();
            $water = $client->post("https://api.fitbit.com/1/user/-/foods/log/water/goal.json", [
                "headers" => [
                    "Authorization" => "Bearer {$me->token}",
                    "Accept-Language"   =>  "fr_FR"
                ],
                "form_params" => [
                    'target' => (int)$amount,
                ]
            ]);
        }
    }

}