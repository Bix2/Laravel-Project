<?php

namespace App\Http\Controllers;

use App\Habit;

use App\Http\CodeBreak\FitBit;
use App\Http\CodeBreak\Stats;
use App\Jobs\DoSomething;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\ClientInterface;
use SocialiteProviders\Manager\SocialiteWasCalled;
use App\User;
use Socialite;
use Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{   
        
    public function test() {
        $me = Auth::user();
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
                "startTime"         =>  "08:20:30",
                "durationMillis"    =>  1800000,
                "date"              =>  "2018-11-26",
                "distance"          =>  3.23,
            ]
        ]);
    }

    public static function index() {
        if (Auth::check()) { 
            $me = Auth::user();
            $data = User::getAllUserData();
            $data['trackedHabits'] = User::getTrackedAndUntrackedHabits();
            return view('dashboard', $data);
        }
        $data = Stats::getDailyTracked();
        return view('welcome', $data);
    }

    public function storeFeedback(Request $request) {
        User::storeMood($request);
        return redirect('/dashboard');
    }

    public function AddWater(Request $request){
        $data = Habit::AddWaterLog($request);
        return $data;
    }

}
