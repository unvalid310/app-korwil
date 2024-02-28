<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index() {
        $role = session()->get('role')[0];

        if ($role === "operator") {
            # code...
            return view('pages.dashboard.dashboard-operator');
        }
        return view('pages.dashboard.dashboard');
    }
}
