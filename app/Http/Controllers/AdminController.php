<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
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
        $this->authorize('makeOperator', User::class);

        $user = User::findOrFail($userId);
        $user->assignRole('operator');

        $restaurantId = $request->input('restaurant_id');
        $restaurant = Restaurant::findOrFail($restaurantId);
        $user->restaurants()->sync([$restaurantId]);

        return redirect()->back()->with('success', 'User has been assigned as an operator.');
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

        return view('admin.subscribers.index');
    }

    public function manageRestaurantOwners()
    {
        $this->authorize('manageRestaurantOwners', User::class);

        $restaurantOwners = User::role('restaurant_owner')->with('subscriptionPlan')->get();
        return view('admin.restaurant_owners.index', ['restaurantOwners' => $restaurantOwners]);
    }

    public function createUserForm()
    {
        $this->authorize('createUser', User::class);

        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function createUser(Request $request)
    {
        $this->authorize('createUser', User::class);

        // Logic to create a new user
    }

    public function editUserForm(User $user)
    {
        $this->authorize('editUser', $user);

        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function editUser(Request $request, User $user)
    {
        $this->authorize('editUser', $user);

        // Logic to update user information
    }

    public function removeOperatorRole($id)
    {
        $this->authorize('removeOperatorRole', User::class);

        // Logic to remove operator role
    }
}
