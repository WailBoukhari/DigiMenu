<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function manageUsers()
    {
        $this->authorize('viewManageUsers', User::class);

        // Fetch users who do not have any roles assigned
        $users = User::doesntHave('roles')->get();
        return view('admin.users.index', compact('users'));
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
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|exists:roles,name',
        ]);

        // Create the user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Assign role to the user
        $user->assignRole($validatedData['role']);

        // Redirect to a success page or return a response
    }

    // Method to display the user editing form
    public function editUserForm(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    // Method to handle user editing
    public function editUser(Request $request, User $user)
    {
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
        ]);

        // Update the user details
        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);

        // Sync user roles
        $user->syncRoles([$validatedData['role']]);

        // Redirect to a success page or return a response
    }
}
