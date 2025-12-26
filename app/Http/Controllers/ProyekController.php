<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProyekController extends Controller
{
    public function admin(){
        return view('admin.proyek');
    }
}
