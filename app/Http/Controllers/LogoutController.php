<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function store(){
        //dd('Cerrando sesión');
        auth()->logout();

        return redirect()->route('login');
    }
}
