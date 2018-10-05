<?php

/*namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use brulath\fitbit\FitbitPHPOAuth2;
use Illuminate\Http\Request;
use App\User;
use Auth;


class FitbitApiController extends Controller {

    public function __construct() {
     
    }

    public function index() {
        return $fitbit = new FitbitPHPOAuth2(
            env('FITBIT_KEY'),
            env('FITBIT_SECRET'),
            env('FITBIT_REDIRECT_URI'),
            ['activity', 'heartrate', 'location', 'nutrition', 'profile', 'settings', 'sleep', 'social', 'weight'], true
         );

         // A session is required to prevent CSRF
         session_start();
            
         $user = $fitbit->getResourceOwner();
         $token = $fitbit->getToken();
         $refresh_token = $fitbit->getRefreshToken();
         $access_token = $fitbit->getAccessToken();
         $profile = $fitbit->getProfile();
         print_r([$profile, $token]);
         
     
         //storeAccessTokenAsJsonInMyDatabase($access_token);
        // return redirect()->intended('/dashboard');
    }

    
}
*/

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use brulath\fitbit\FitbitPHPOAuth2;
use brulath\fitbit\FitbitUser;
use brulath\fitbit\FitbitProvider;
use Illuminate\Http\Request;
use App\User;
use Auth;

class FitbitApiController extends Controller {

    protected function index() {  
            $fitbit = new FitbitPHPOAuth2(
                '22D8C4',
                '1af060bab766acb1396c7f43a2144c4c',
                'http://homestead.test/login/fitbit/callback',
                ['activity', 'heartrate', 'location', 'nutrition', 'profile', 'settings', 'sleep', 'social', 'weight'], true
            );
            
            // A session is required to prevent CSRF
            //session_start();
            
            $token = $fitbit->getToken();
            $refresh_token = $fitbit->getRefreshToken();
            $access_token = $fitbit->getAccessToken();
            $profile = $fitbit->getProfile();
            print_r([$profile, $token]);

           /* if ($user = User::where('fitbit_id', $encodedId)->first()) { 
                return $user;
            };*/
            //storeAccessTokenAsJsonInMyDatabase($access_token);
           // return redirect()->intended('/dashboard');
       
    }
/*
    private function findOrCreateUser($user) {
        if ($user = User::where('fitbit_id', $data->encodedId)->first()) {
            return $user;
        }
        return User::create([
                'token' => $access_token,
                'fitbit_id' => $user_id,
                'name'   => $data->name,
                'avatar' => $data->avatar
            ]);
    }*/
}
