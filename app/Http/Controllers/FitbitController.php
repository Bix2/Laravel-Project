<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;

class FitbitController extends Controller
{
    protected function redirectToFitbit()
    {
        return Socialite::driver('fitbit')
            ->setScopes(['activity', 'heartrate', 'location', 'nutrition', 'profile', 'settings', 'sleep', 'weight'])
            ->redirect();
    }

    protected function handleUserInfo()
    {   
        $data = Socialite::driver('fitbit')->user();
        $user = $this->findOrCreateUser($data);
        
        //redirecting to home page
        return redirect()->intended('/dashboard');
        dd($user);
    }

    public function findOrCreateUser($data) {
        $user = User::where('fitbit_id', $data->id)->first();
        if ($user) {
            return $user;
        }
        return User::create([
            'token' => $data->token,
            'fitbit_id' => $data->id,
            'name'   => $data->name,
            'avatar' => $data->avatar
        ]);
    }
}