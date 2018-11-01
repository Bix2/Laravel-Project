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

    public static function getStatsSleepWeekly() {
        if (Auth::check()) { 
            $me = Auth::user();
            $sixDaysAgo = date("Y-m-d", strtotime('-6 days'));

            $currentDateSleep = \DB::table('sleeplogs')
                ->where('date_of_sleep','>=',$sixDaysAgo)
                ->where('user_id', $me->id)
                ->get();

            header('Content-Type: application/json');
            echo json_encode($currentDateSleep);
        }
    }

    public static function getStatsActivityWeekly() {
        if (Auth::check()) { 
            $me = Auth::user();
            $sixDaysAgo = date("Y-m-d", strtotime('-6 days'));
            $goal = \DB::table('habit_user')
                ->where('habit_id', 4)
                ->where('user_id', $me->id)
                ->first();
            $lastActivities = \DB::table('activitylogs')
                ->where('date','>=',$sixDaysAgo)
                ->where('user_id', $me->id)
                ->get();

            $response[] = [
                'goal'          => $goal->goal,
                'activitylogs'   => $lastActivities
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    public static function getStatsSleepDaily() {
        if (Auth::check()) { 
            $me = Auth::user();
            $currentdate = date("Y-m-d");

            $currentDateSleep = \DB::table('sleeplogs')
                ->where('date_of_sleep', $currentdate)
                ->where('user_id', $me->id)
                ->first();

            header('Content-Type: application/json');
            echo json_encode($currentDateSleep);
        }
    }

    public static function getStatsActivityDaily() {
        if (Auth::check()) { 
            $me = Auth::user();
            $currentdate = date("Y-m-d");
            $currentDateActivity = \DB::table('activitylogs')
                ->where('date', $currentdate)
                ->where('user_id', $me->id)
                ->first();
            $goal = \DB::table('habit_user')
                ->where('habit_id', 4)
                ->where('user_id', $me->id)
                ->first();

            $response[] = [
                'goal'          => $goal->goal,
                'activitylogs'   => $currentDateActivity
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    // TESTING: Google Chrome Extention
    public static function getStatsForChromeExtention() {

        // get current steps
        // $me = User::where(token = token);
        $me = Auth::user();
        $currentdate = date("Y-m-d");
        $usersteps = \DB::table('activitylogs')->where('user_id', $me->id)->where('date', $currentdate)->get();
        $totalsteps = 0;
        foreach ($usersteps as $userstep) {
            if($userstep->steps > $totalsteps){
                $totalsteps = $userstep->steps;
            }
            
        }

        // get goal
        $stepsgoal = 0;
        $usergoals = \DB::table('habit_user')->where('user_id', $me->id)->get();
        foreach ($usergoals as $usergoal) {
            if($usergoal->habit_id == 4) {
                $stepsgoal = $usergoal->goal;
            }
        }

        $response = [
            "userName"          =>      $me->name,
            "userAvatar"        =>      $me->avatar,
            "currentDate"       =>      $currentdate,
            "totalSteps"        =>      $totalsteps,
            "stepsGoal"         =>      $stepsgoal
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    

    public function isAdmin() {
        return $this->admin; // this looks for an admin column in your users table
    }

    public function habits() {
        return $this->belongsToMany('App\Habit', 'habit_user', 'user_id', 'habit_id');
    }
    
}
