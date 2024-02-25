<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\RandomPasswordEmail;
use App\Models\Restaurant;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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

        // Associate the operator with the restaurant
        $restaurant->operators()->attach($user);

        return redirect()->back()->with('success', 'User has been assigned as an operator.');
    }


    public function removeOperatorRole($id)
    {
        $operator = User::findOrFail($id);

        // Detach the operator role
        $operator->removeRole('operator');

        // Remove the association with any restaurant
        $operator->restaurants()->detach();

        return redirect()->back()->with('success', 'Operator role removed successfully.');
    }

    public function manageOperators()
    {
        $this->authorize('manageUsers', User::class);

        $operators = User::role('operator')->get();
        return view('admin.operators.index', compact('operators'));
    }


    public function createUserForm()
    {
        $this->authorize('manageUsers', User::class);

        return view('admin.users.create');
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $password = Str::random(12);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password), 
        ]);

        Mail::to($user->email)->send(new RandomPasswordEmail($user, $password));

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function editUserForm(User $user)
    {
        $this->authorize('manageUsers', $user);

        return view('admin.users.edit', compact('user'));
    }

    public function editUser(Request $request, User $user)
    {
        $this->authorize('manageUsers', $user);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only(['name', 'email']));

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }
    public function destroyUser(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
    public function manageSubscribers()
    {
        $subscriptionPlans = SubscriptionPlan::all();

        return view('admin.subscribers.index', compact('subscriptionPlans'));
    }
    public function createSubscribers()
    {
        return view('admin.subscribers.create');
    }

    // Store a new subscription plan
    public function storeSubscribers(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'scan_limit' => 'nullable|integer|min:0',
            'dish_creation_limit' => 'nullable|integer|min:0',
        ]);

        SubscriptionPlan::create($validatedData);

        return redirect()->route('subscription.index')->with('success', 'Subscription plan created successfully.');
    }

    // Show the form to edit a subscription plan
    public function editSubscribers($id)
    {
        $subscriptionPlan = SubscriptionPlan::findOrFail($id);
        return view('admin.subscribers.edit', compact('subscriptionPlan'));
    }

    // Update a subscription plan
    public function updateSubscribers(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'scan_limit' => 'nullable|integer|min:0',
            'dish_creation_limit' => 'nullable|integer|min:0',
        ]);

        $subscriptionPlan = SubscriptionPlan::findOrFail($id);
        $subscriptionPlan->update($validatedData);

        return redirect()->route('admin.subscribers.index')->with('success', 'Subscription plan updated successfully.');
    }

}
