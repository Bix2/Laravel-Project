<?php

namespace App\Http\Controllers;

use App\Http\CodeBreak\FitBit;
use App\Http\CodeBreak\Stats;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\ClientInterface;
use App\User;
use Socialite;
use Auth;
use Hash;

class UserController extends Controller
{
    
    public function redirectToFitbit() {
        return Socialite::driver('fitbit')
            ->setScopes(['activity', 'heartrate', 'location', 'nutrition', 'profile', 'settings', 'sleep', 'weight'])
            ->redirect();
    }

    /**
     * Obtain the user information from Fitbit.
     *
     */
    public function handleFitbitCallback() {   
        $data = Socialite::driver('fitbit')->user();
        if ($data) {
            $user = $this->findOrCreateUser($data);
            // manually loggging in a user
            Auth::login($user);    

            // if new user get full week data
            if($user->new == true) {
                $sleep = FitBit::getSleepPatternWeek();
                FitBit::insertSleepWeekToDB($sleep);
                $steps = FitBit::getActivityStepsWeek();
                FitBit::insertStepsWeekToDB($steps);
                $water = FitBit::getWaterLogWeek();
                FitBit::insertWaterLogWeekToDB($water);
            } else {
                $steps = FitBit::getActivitySteps();
                FitBit::insertStepsToDB($steps);
                $sleep = FitBit::getSleepPattern();
                FitBit::insertSleepToDB($sleep);
                $water = FitBit::getWaterLog();
                FitBit::insertWaterLogToDB($water);
            }
        }  
        return redirect()->intended('/dashboard')->with(['user' => $user]);  
    }

    /**
     * Return user if exists; create and return if doesn't
     * 
     */
    private function findOrCreateUser($data) {
        $user = User::where('fitbit_id', $data->id)->first();
        // if user is found in db
        if ($user) {
            // update access token
            $user->update([
                'token' => $data->token,
                'remember_token' => $data->refreshToken,
                'fitbit_id' => $data->id,
                'name'   => $data->name,
                'avatar' => $data->avatar,
            ]);
            //mass assignment
            $user->new = false;
            return $user;
        }
        // else store user in db
        $user = User::create([
            'token' => $data->token,
            'remember_token' => $data->refreshToken,
            'fitbit_id' => $data->id,
            'name'   => $data->name,
            'avatar' => $data->avatar,
            'admin' => 0
        ]);
        $user->new = true;
        return $user;
    }

    public function logout() {
        Auth::logout();
        $data = Stats::getDailyTracked();
        return view('welcome', $data);
    }

    public function delete() {
        User::deleteAccount();
        $data = Stats::getDailyTracked();
        return view('welcome', $data);
    }
    
    public static function showProfile() {
        $data = FitBit::getProfileInfo();
        $data['trackedHabits'] = User::getTrackedAndUntrackedHabits();
        return view('profile', $data);
    }

    public function getStats() {
        User::getStatsForChromeExtention();
    }

    public function getWeekSleepStats() {
        User::getStatsSleepWeekly();
    }

    public function getWeekActivityStats() {
        User::getStatsActivityWeekly();
    }

    public function getDaySleepStats() {
        User::getStatsSleepDaily();
    }

    public function getDayActivityStats() {
        User::getStatsActivityDaily();
    }

    public function getDayBreathingStats() {
        User::getStatsBreathingDaily();
    }

    public function getDayWaterStats() {
        User::getStatsWaterDaily();
    }
    

}
