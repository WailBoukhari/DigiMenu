<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function dashboard() {
        return view('admin.admin_dahbaord');
    }
    public function manageUsers()
    {

        $this->authorize('manageUsers', User::class);

        $operators = User::role('operator')->get();
        $users = User::doesntHave('roles')->get();
        $restaurants = Restaurant::all();

        return view('admin.users.index', compact('operators', 'users', 'restaurants'));
    }

    public function makeOperator(Request $request, $userId)
    {
        $this->authorize('manageUsers', User::class);

        $restaurantId = $request->input('restaurant_id');
        $restaurant = Restaurant::findOrFail($restaurantId);

        $user = User::findOrFail($userId);
        $user->assignRole('operator');

        // Set the restaurant_id on the user model
        $user->restaurant_id = $restaurantId;
        $user->save();

        return redirect()->back()->with('success', 'User has been assigned as an operator.');
    }


    public function removeOperatorRole($id)
    {
        $operator = User::findOrFail($id);

        // Detach the operator role
        $operator->removeRole('operator');

        // Remove the association with the restaurant by setting restaurant_id to null
        $operator->restaurant_id = null;
        $operator->save();

        return redirect()->back()->with('success', 'Operator role removed successfully.');
    }
    public function manageOperators()
    {
        $this->authorize('manageUsers', User::class);

        $operators = User::role('operator')->get();
        return view('admin.operators.index', compact('operators'));
    }

    public function manageSubscribers()
    {
        $this->authorize('manageSubscribers', User::class);

        return view('admin.subscribers.index');
    }

    public function manageRestaurantOwners()
    {
        $this->authorize('manageUsers', User::class);

        $restaurantOwners = User::role('restaurant_owner')->with('subscriptionPlan')->get();
        return view('admin.restaurant_owners.index', ['restaurantOwners' => $restaurantOwners]);
    }

    public function createUserForm()
    {
        $this->authorize('manageUsers', User::class);

        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function createUser(Request $request)
    {
        $this->authorize('manageUsers', User::class);

        // Logic to create a new user
    }

    public function editUserForm(User $user)
    {
        $this->authorize('manageUsers', $user);

        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function editUser(Request $request, User $user)
    {
        $this->authorize('manageUsers', $user);

        // Logic to update user information
    }
}
