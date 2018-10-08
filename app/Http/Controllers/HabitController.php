<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HabitController extends Controller
{
    public function show($habit) {
        if (Auth::check()) { 
            // save user data to variable $me
            $me = Auth::user();
            $data['user'] = $me;
            $data['habit'] = \DB::table('habits')->where('type', $habit)->first();
            $isTracked = $this->isHabitTracked($data['habit']->id, $me->id);
            if($isTracked) {
                $data['button'] = ["text" => "Stop tracking this habit"];
            } else {
                $data['button'] = ["text" => "Track this habit"];
            }
            return view('habit', $data);
        }
    }

    public function trackHabit($habit) {
        if (Auth::check()) { 
            $me = Auth::user();
            $data['user'] = $me;
            $data['habit'] = \DB::table('habits')->where('type', $habit)->first();
            $isTracked = $this->isHabitTracked($data['habit']->id, $me->id);
            if($isTracked) {
                \DB::table('habit_user')->where([
                    ['habit_id', '=', $data['habit']->id],
                    ['user_id', '=', $me->id]
                ])->delete();
                $data['button'] = ["text" => "Track this habit"];
            } else {
                \DB::table('habit_user')->insert(
                    ['habit_id' => $data['habit']->id, 'user_id' => $me->id]
                );
                $data['button'] = ["text" => "Stop tracking this habit"];
            }
            return view('habit', $data);
        }
    }

    public function isHabitTracked($habitId, $userId) {
        $habit = \DB::table('habit_user')->where([
            ['habit_id', '=', $habitId],
            ['user_id', '=', $userId]
        ])->first();
        return !empty($habit);
    }

}
