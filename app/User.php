<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'fitbit_id', 'token', 'avatar', 'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getAllUserData() {
        // check if user is loggedin
        if (Auth::check()) { 
            // save user data to variable $me
            $me = Auth::user();
            // get all habits
            $habits = \DB::table('habits')->get();
            // get habit tracked by user
            $trackedHabitsDetails = Auth::user()->habits->first();
            if ($trackedHabitsDetails) { 
                $trackedHabitsDetails = $trackedHabitsDetails->pivot->pivotParent->habits;
            }

            // get tracked and untracked habits
            $trackedHabitsArray = [];
            $untrackedHabitsArray = [];
            
            foreach ($habits as $habit){
                $habitCheck = -1;
                if($trackedHabitsDetails){
                    foreach($trackedHabitsDetails as $trackedhabitDetails) {
                        if ($trackedhabitDetails->getOriginal('pivot_habit_id') == ($habit->id) ) {
                            $habitCheck =  $habit->id;
                        }
                    }
                }
                if( $habitCheck > -1) {
                    array_push($trackedHabitsArray, $habit);
                } else {
                    array_push($untrackedHabitsArray, $habit);
                }
            }

            if (!empty($trackedHabitsArray)) {
                $currentdate = date("Y-m-d");
                foreach ($trackedHabitsArray as $habit) {
                    if($habit->type == "sleep") {
                        $totalsleep = 0;
                        $usersleep = \DB::table('sleeplogs')->where([['user_id', $me->id], ['date_of_sleep', $currentdate]])->get();
                        $sleepgoal = \DB::table('habit_user')->where([['user_id', $me->id], ['habit_id', 1]])->first();
                        foreach ($usersleep as $sleep) {
                            if($sleep->deep_minutes > $totalsleep){
                                $totalsleep = $sleep->deep_minutes;
                            }
                        }
                        $data['trackedHabitsInfo']['totalsleep'] = $totalsleep;
                        $data['trackedHabitsInfo']['sleepgoal'] = $sleepgoal;
                    }
                    if($habit->type == "water") {
                        $userwater = \DB::table('waterlogs')->where([['user_id', $me->id], ['date', $currentdate]])->first();
                        $watergoal = \DB::table('habit_user')->where([['user_id', $me->id], ['habit_id', 2]])->first();
                        $data['trackedHabitsInfo']['userwater'] = $userwater->amount;
                        $data['trackedHabitsInfo']['watergoal'] = $watergoal->goal;
                    }
                    if($habit->type == "breathing") {
                        $totalbreathing = 0;
                        $userbreathing = \DB::table('breathing')->where('user_id', $me->id)->get();
                        $breathinggoal = \DB::table('habit_user')->where([['user_id', $me->id], ['habit_id', 3]])->first();
                        foreach ($userbreathing as $breathing) {
                            if($breathing->time > $totalbreathing){
                                $totalbreathing = $breathing->time;
                            }
                        }
                        $data['trackedHabitsInfo']['totalbreathing'] = $totalbreathing;
                        $data['trackedHabitsInfo']['breathinggoal'] = $breathinggoal;
                    }
                    if($habit->type == "exercise") {
                        $usersteps = \DB::table('activitylogs')->where([['user_id', $me->id], ['date', $currentdate]])->first();
                        $stepsgoal = \DB::table('habit_user')->where([['user_id', $me->id], ['habit_id', 4]])->first();
                        $data['trackedHabitsInfo']['usersteps'] = $usersteps->steps;
                        $data['trackedHabitsInfo']['stepsgoal'] = $stepsgoal->goal;
                    }
                }
            }

            $data['trackedHabitsArray'] = $trackedHabitsArray;
            $data['untrackedHabitsArray'] = $untrackedHabitsArray;
            $data['user'] = $me;
            $data['habits'] = $habits;
            $data['trackedHabitsDetails'] = $trackedHabitsDetails;
            
            return $data;
        }
    }
    

    public function isAdmin() {
        return $this->admin; // this looks for an admin column in your users table
    }

    public function habits() {
        return $this->belongsToMany('App\Habit', 'habit_user', 'user_id', 'habit_id');
    }
    
}
