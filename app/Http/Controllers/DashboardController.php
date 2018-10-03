<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        // $data['user'] = \DB::table('artists')->get();
        return view('dashboard');
    }
}
