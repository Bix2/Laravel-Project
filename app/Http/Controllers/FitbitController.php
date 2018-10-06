<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;
use GuzzleHttp\Client;

class FitbitController extends Controller
{
    /**
     * Redirect the user to the Fitbit authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    protected function redirectToFitbit()
    {
        return Socialite::driver('fitbit')
            ->setScopes(['activity', 'heartrate', 'location', 'nutrition', 'profile', 'settings', 'sleep', 'weight'])
            ->redirect();
    }

    /**
     * Obtain the user information from Fitbit.
     *
     * @return \Illuminate\Http\Response
     */
    protected function handleUserInfo()
    {   
        $data = Socialite::driver('fitbit')->user();
        if ($data) {
            $user = $this->findOrCreateUser($data);
            Auth::login($user, true);
        };
        //redirecting to dashboard page
        return redirect()->intended('/dashboard')->with(['user' => $user]);
    }

    /**
     * Return user if exists; create and return if doesn't
     * 
     * @param $data
     * @return User
     */
    private function findOrCreateUser($data) {
        if ($user = User::where('fitbit_id', $data->id)->first()) {
            return $user;
        }
        return User::create([
                'token' => $data->token,
                'fitbit_id' => $data->id,
                'name'   => $data->name,
                'avatar' => $data->avatar
            ]);
    }

    public function getSleepLogs() {
        $client = new Client([
            'base_uri' => 'https://api.fitbit.com',
        ]);
        $request = $client->request('GET', '/1.2/user/-/sleep/date/' . date('Y-m-d') . '.json', [
            'headers' => [
                'Authorization' => 'Bearer ' . auth()->user()->token,
            ],
        ]);
        return $request->getBody()->getContents();
    }
}