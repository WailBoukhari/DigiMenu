<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


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
    public function subscriptionStatus($userId)
    {
        $user = User::find($userId);

        // Check if the user exists
        if (!$user) {
            return "User not found.";
        }

        // Check if the user has a subscription and if it has expired
        if ($user->subscription_end_date && Carbon::now()->gte($user->subscription_end_date)) {
            // Subscription has expired, display relevant information and show ending message
            $subscriptionEndDate = $user->subscription_end_date;
            $message = "Your subscription has expired on {$subscriptionEndDate}. Renew your subscription to continue accessing the service.";

            // Display other relevant information to the user
            // You can fetch and display additional user-related data here
        } else {
            // Subscription is still active, no action needed
            $message = "Your subscription is still active.";
        }

        // Pass the message and other relevant data to the view
        return view('subscription_end', compact('message'));
    }

}
