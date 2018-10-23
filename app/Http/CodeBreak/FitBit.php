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

    // Get the steps of the user from FitBit API
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

    // Get the sleep pattern of the user from FitBit API
    public static function getSleepPattern() {
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

}