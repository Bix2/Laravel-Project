<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;

class AuthController extends Controller
{
    protected function newFitBit()
    {
        return Socialite::driver('fitbit')->redirect();
    }

    protected function storeFitBit()
    {   
        $user = Socialite::driver('fitbit')->user();
        dd($user);
    }
}