<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin(){
        $user = Auth::user();
        $role = $user->hasRole('admin');

        return view('dashboard.admin', compact('user', 'role' ));
    }

    public function teacher(){
        $user = Auth::user();
        $role = $user->hasRole('teacher');

        return view('dashboard.teacher', compact('user', 'role'));
    }
    public function student(){
        $user = Auth::user();
        $role = $user->hasRole('student');

        return view('dashboard.student', compact('user', 'role' ));
    }
    public function customer(){
        $user = Auth::user();
        $role = $user->hasRole('customer');

        return view('dashboard.customer', compact('user', 'role' ));
    }
    public function supplier(){
        $user = Auth::user();
        $role = $user->hasRole('supplier');
        return view('dashboard.supplier', compact('user', 'role'));
    }


}
