<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function manageRestaurantOwners()
    {
        $this->authorize('manageRestaurantOwners', User::class);

        $restaurantOwners = User::role('restaurant_owner')->get();
        return view('admin.restaurant_owners.index', compact('restaurantOwners'));
    }

    public function manageOperators()
    {
        $this->authorize('manageOperators', User::class);

        $operators = User::role('operator')->get();
        return view('admin.operators.index', compact('operators'));
    }

    public function manageSubscribers()
    {
        $this->authorize('manageSubscribers', User::class);

        $subscribers = User::role('subscriber')->get();
        return view('admin.subscribers.index', compact('subscribers'));
    }
}
