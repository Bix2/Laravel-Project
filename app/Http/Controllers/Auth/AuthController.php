<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
        $user = Socialite::driver('fitbit')->user();
        $token = $user->token;
        print_r($user);
   
    }
}