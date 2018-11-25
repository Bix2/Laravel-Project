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
        'name', 'email', 'password', 'fitbit_id', 'remember_token', 'token', 'avatar', 'admin'
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
                            $totalSleepMinutes = $sleep->deep_minutes + $sleep->wake_minutes + $sleep->rem_minutes + $sleep->light_minutes;
                            if($sleep->deep_minutes > $totalsleep){
                                $totalsleep = $totalSleepMinutes;
                            }
                        }
                        $data['trackedHabitsInfo']['sleep']['amount'] = $totalsleep;
                        $data['trackedHabitsInfo']['sleep']['goal'] = $sleepgoal->goal;
                        $data['userProgress']['sleep_progress'] = User::checkHabitProgress($totalsleep, $sleepgoal->goal);
                    }
                    if($habit->type == "water") {
                        $userwater = \DB::table('waterlogs')->where([['user_id', $me->id], ['date', $currentdate]])->first();
                        $watergoal = \DB::table('habit_user')->where([['user_id', $me->id], ['habit_id', 4]])->first();
                        $data['trackedHabitsInfo']['water']['amount'] = $userwater->amount;
                        $data['trackedHabitsInfo']['water']['goal'] = $watergoal->goal;
                        $data['userProgress']['water_progress'] = User::checkHabitProgress($userwater->amount, $watergoal->goal);
                    }
                    if($habit->type == "breathing") {
                        $totalbreathing = 0;
                        $userbreathing = \DB::table('breathing')->where('user_id', $me->id)->get();
                        $breathinggoal = \DB::table('habit_user')->where([['user_id', $me->id], ['habit_id', 2]])->first();
                        foreach ($userbreathing as $breathing) {
                            $totalbreathing++;
                        }
                        $data['trackedHabitsInfo']['breathing']['amount'] = $totalbreathing;
                        $data['trackedHabitsInfo']['breathing']['goal'] = $breathinggoal->goal;
                        $data['userProgress']['breathing_progress'] = User::checkHabitProgress($totalbreathing, $breathinggoal->goal);
                    }
                    if($habit->type == "exercise") {
                        $usersteps = \DB::table('activitylogs')->where([['user_id', $me->id], ['date', $currentdate]])->first();
                        $stepsgoal = \DB::table('habit_user')->where([['user_id', $me->id], ['habit_id', 3]])->first();
                        $data['trackedHabitsInfo']['steps']['amount'] = $usersteps->steps;
                        $data['trackedHabitsInfo']['steps']['goal'] = $stepsgoal->goal;
                        $data['userProgress']['steps_progress'] = User::checkHabitProgress($usersteps->steps, $stepsgoal->goal);
                    }
                }
            }

            $data['userGoalsAchieved'] = false;
            // if any habit is tracked
            if(!empty($data['trackedHabitsInfo'])) {
                $data['userGoalsAchieved'] = User::checkIfTrackedGoalsAchieved($data['trackedHabitsInfo']);
            }
            $data['trackedHabitsArray'] = $trackedHabitsArray;
            $data['untrackedHabitsArray'] = $untrackedHabitsArray;
            $data['user'] = $me;
            $data['habits'] = $habits;
            $data['trackedHabitsDetails'] = $trackedHabitsDetails;
            return $data;
        }
    }

    public static function getTrackedAndUntrackedHabits() {
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

        $habitsArray = [
            $trackedHabitsArray,
            $untrackedHabitsArray
        ];

        return $habitsArray;
    }

    public static function checkIfTrackedGoalsAchieved($habits) {
        // for each tracked habit check if goal achieved
        foreach ($habits as $habit) {
            // if goal is not achieved return false
            if(!($habit['amount'] >= $habit['goal'])) {
                return false;
            }
        }
        return true;
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
                ->where('habit_id', 3)
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
                ->where('habit_id', 3)
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

    public static function getStatsBreathingDaily() {
        if (Auth::check()) { 
            $me = Auth::user();
            $currentdate = date("Y-m-d");
            $currentDateBreathing = \DB::table('breathing')
                ->where('date', $currentdate)
                ->where('user_id', $me->id)
                ->get();

            header('Content-Type: application/json');
            echo json_encode($currentDateBreathing);
        }
    }

    public static function getStatsWaterDaily() {
        if (Auth::check()) { 
            $me = Auth::user();
            $currentdate = date("Y-m-d");
            $currentDateWater = \DB::table('waterlogs')
                ->where('date', $currentdate)
                ->where('user_id', $me->id)
                ->first();
            $goal = \DB::table('habit_user')
                ->where('habit_id', 4)
                ->where('user_id', $me->id)
                ->first();

            $response[] = [
                'goal'        => $goal->goal,
                'waterlogs'   => $currentDateWater
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

    // public static function checkIfStepsGoalCompleted() {
    //     if (Auth::check()) { 
    //         $me = Auth::user();
    //         $currentdate = date("Y-m-d");
    //         $usersteps = \DB::table('activitylogs')->where([['user_id', $me->id], ['date', $currentdate]])->first();
    //         $stepsgoal = \DB::table('habit_user')->where([['user_id', $me->id], ['habit_id', 3]])->first();
    //     }
    // }

    public static function checkHabitProgress($userProgress, $userGoal) {
        $habitProgress = [];
        $message;
        $status;
        if($userProgress == 0) {
            $message = "You have no records registered for this habit today.";
            $status = "warning";
        } elseif($userProgress < $userGoal) {
            $message = "You are making progress! Keep up the great work!";
            $status = "warning";
        } else {
            $message = "Nailed it! You met your goal for today";
            $status = "success";
        }
        $status = [
            'message'   =>  $message,
            'status'    =>  $status
        ];
        return $status;
    }
    

    public function isAdmin() {
        return $this->admin; // this looks for an admin column in your users table
    }

    public function habits() {
        return $this->belongsToMany('App\Habit', 'habit_user', 'user_id', 'habit_id');
    }
    
}
