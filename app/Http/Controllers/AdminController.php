<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    public function index() {
        if (Auth::check()) { 
            // save user data to variable $me
            $me = Auth::user();
            $data['user'] = $me;
            if ($me->admin == 1) {
                $users = \DB::table('user_moods')
                ->join('users', 'user_moods.user_id', '=', 'users.id')
                ->join('habits', 'user_moods.habit_id', '=', 'habits.id')
                ->select('user_moods.mood', 'users.name', 'users.admin', 'habits.type')
                ->orderBy('users.name')
                ->get();
                $data['users'] = $users;
                return view('admin', $data);
            } else {
                return view('admin', $data);
            }
        }
    }
}
