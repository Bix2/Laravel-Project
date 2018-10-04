<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $user = session()->get('user');
        return view('dashboard')->with(['user' => $user]);
    }
}
