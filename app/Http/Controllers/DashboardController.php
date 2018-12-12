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
        $request["amount"] = $request["amount"]*1000;
        FitBit::AddWaterLog($request);
        $water = FitBit::getWaterLog();
        FitBit::insertWaterLogToDB($water);
    }

    public function WaterGoal(Request $request){
        FitBit::ChangeWaterGoal($request);
        $goal = FitBit::getWaterLogGoal();
        FitBit::changeWaterGoalInDB($goal);
    }

}
