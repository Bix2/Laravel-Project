<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\ClientInterface;
use App\User;
use Socialite;
use Auth;
use Hash;

class FitbitAuthController extends Controller {
    /**
     * Redirect the user to the Fitbit authentication page.
     *
     */
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
                'fitbit_id' => $data->id,
                'name'   => $data->name,
                'avatar' => $data->avatar
            ]);
            return $user;
        }
        // else store user in db
        return $user = User::create([
            'token' => $data->token,
            'fitbit_id' => $data->id,
            'name'   => $data->name,
            'avatar' => $data->avatar
        ]);
    }

    public function showProfile() {
        // determine if a user is authenticated
        if (Auth::check()) { 
            // return the authenticated user
            $me = Auth::user();
 
            $client = new Client([
                "base_uri" => "https://api.fitbit.com/1/",
            ]);

            $response = $client->get("user/-/profile.json", [
                "headers" => [
                    "Authorization" => "Bearer {$me->token}"
                ]
            ]);

            $profile = json_decode($response->getBody(), true);
            print_r($profile);
            //return view('profile')->with(['profile' => $profile]);
        }
    }




}
