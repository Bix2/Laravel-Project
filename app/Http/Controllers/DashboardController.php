<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        if (session()->has('user')) {
            $user = session()->get('user');
            return view('dashboard')->with(['user' => $user]);
        } else {
            return redirect()->intended('/');
        }
    }
}
