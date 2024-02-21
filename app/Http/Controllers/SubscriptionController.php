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
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);

        $user = auth()->user();

        $expirationDate = Carbon::now()->addMonth();

        $user->subscriptionPlan()->associate($plan);
        $user->subscription_expires_at = $expirationDate;
        $user->save();

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
