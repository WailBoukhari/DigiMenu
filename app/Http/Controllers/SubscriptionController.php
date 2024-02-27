<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SubscriptionController extends Controller
{
    public function showSubscriptionForm()
    {
        // Retrieve subscription plans from the database
        $plans = SubscriptionPlan::all();

        return view('subscription.subscribe', ['plans' => $plans]);
    }

    public function processSubscription(Request $request)
    {
        // Validate the form data
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
        ]);

        // Get the selected plan
        $plan = SubscriptionPlan::findOrFail($request->plan_id);

        // Get the authenticated user
        $user = auth()->user();

        // Calculate the expiration date based on the plan duration
        $expirationDate = Carbon::now()->addMonth();

        // Associate the plan with the user and set the expiration date
        $user->subscriptionPlan()->associate($plan);
        $user->subscription_expires_at = $expirationDate;
        $user->save();

        // Check if the user previously had a soft deleted menu
        $deletedMenus = $user->menus()->onlyTrashed()->get();

        // Restore all deleted menus and their associated menu items
        $deletedMenus->each(function ($menu) {
            $menu->restore();
            $menu->menuItems()->restore();
        });

        // Redirect the user to a success page or perform any other action
        return redirect()->route('restaurant_owner.dashboard')->with('success', 'Subscription successful. You are now subscribed to ' . $plan->name . ' until ' . $expirationDate->format('Y-m-d') . '.');
    }

}