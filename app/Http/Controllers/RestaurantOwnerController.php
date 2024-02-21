<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestaurantOwnerController extends Controller
{
    public function dashboard() {

       return view('restaurant_owner.dashboard');
    }
}
