<?php

namespace App\Http\Controllers;

use App\Models\Country;

class DashboardController extends Controller
{
    public function show(){
        $countries = Country::all();
        return view('dashboard')->with([ 'countries' => $countries ]);
    }
}
