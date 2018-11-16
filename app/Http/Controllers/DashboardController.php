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
    public function index() {
        if (Auth::check()) { 
            $me = Auth::user();
            $data = FitBit::getActivitySteps();
            // insert steps to database just for testing
            FitBit::insertStepsToDB($data);

            $data = FitBit::getSleepPattern();
            // insert steps to database just for testing
            FitBit::insertSleepToDB($data);

            $data = FitBit::getWaterLog();
            // insert water to database just for testing
            FitBit::insertWaterLogToDB($data);
            
            $data = User::getAllUserData();
            $data['trackedHabits'] = User::getTrackedAndUntrackedHabits();
            return view('dashboard', $data);
        }
        $data = Stats::getDailyTracked();
        return view('welcome', $data);
    }

    public function storeFeedback(Request $request) {
        //dd($request->all());
        if (Auth::check()) { 
            $me = Auth::user();
            $currentdate = date("Y-m-d");
            $usergoals = \DB::table('habit_user')->where('user_id', $me->id)->get();
            foreach ($usergoals as $usergoal) {
                if($usergoal->habit_id == 4) {
                    \DB::table('user_moods')->insert([
                        'date' => $currentdate,
                        'mood' => $request->input('mood'),
                        'habit_id' => $usergoal->habit_id,
                        'user_id' => $me->id,
                    ]); 
                }
            }
        }
    }

    public function AddWater(Request $request){
        $data = Habit::AddWaterLog($request);
        return $data;
    }

    // Jobs Testing
    public function doSomething()
    {
        DoSomething::dispatch()
                ->delay(now()->addSeconds(10));
    }

    
}
