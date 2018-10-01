<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\FitBitUser;
use Socialite;

class AuthController extends Controller
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
        return view ( 'dashboard')->with('user', $user);
    }

    public function findOrCreateUser($data) {
        $user = FitBitUser::where('fitbit_id', $data->id)->first();
        if ($user) {
            return $user;
        }
        return FitBitUser::create([
            'token' => $data->token,
            'fitbit_id' => $data->id,
            'name'   => $data->name,
            'avatar' => $data->avatar
        ]);
    }
}