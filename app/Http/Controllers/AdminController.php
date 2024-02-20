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
        $this->authorize('viewManageUsers', User::class);

        // Fetch users who do not have the operator role assigned
        $operators = User::role('operator')->get();

        // Fetch users who do not have any roles assigned
        $users = User::doesntHave('roles')->get();

        // Fetch all restaurants for the dropdown menu
        $restaurants = Restaurant::all();

        return view('admin.users.index', compact('operators', 'users', 'restaurants'));
    }

    public function makeOperator(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        // Add the operator role to the user
        $user->assignRole('operator');

        // Associate the user with the selected restaurant
        $restaurantId = $request->input('restaurant_id');
        $restaurant = Restaurant::findOrFail($restaurantId);
        $user->restaurants()->sync([$restaurantId]);

        return redirect()->back()->with('success', 'User has been assigned as an operator.');
    }
    public function manageOperators()
    {
        $this->authorize('viewManageOperators', User::class);

        $operators = User::role('operator')->get();
        return view('admin.operators.index', compact('operators'));
    }

    public function manageSubscribers()
    {
        $this->authorize('viewManageSubscribers', User::class);

        // $subscribers = User::role('subscriber')->get();
        return view('admin.subscribers.index');
    }
    // Method to display the user creation form
    public function createUserForm()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    // Method to handle user creation
    public function createUser(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        $user->assignRole($validatedData['role']);

    }

    public function editUserForm(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function editUser(Request $request, User $user)
    {
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
        ]);

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);

        $user->syncRoles([$validatedData['role']]);
    }

    public function removeOperatorRole($id)
    {
        $user = User::findOrFail($id);

        $user->removeRole('operator');

        return redirect()->back()->with('success', 'Operator role removed successfully.');
    }
}
