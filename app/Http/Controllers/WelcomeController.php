<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function show()
    {
        if (! Auth::check()) {
            return redirect('/login');
        }
        return redirect('/dashboard'); 
    }
}
