<!-- resources/views/test-subscription.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dash') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @php
                        // Retrieve the logged-in user
                        $user = auth()->user();
                        
                        // Check if the user has a subscription and if it has ended
                        $hasSubscription = $user->subscriptionPlan;
                        $subscriptionExpired = $user->subscription_expires_at && now() > $user->subscription_expires_at;
                        
                        // Calculate remaining time if subscription exists
                        $remainingTime = null;
                        if ($hasSubscription && !$subscriptionExpired) {
                            $remainingTime = now()->diff($user->subscription_expires_at)->format('%d days %h hours %i minutes');
                        }
                    @endphp

                    @if ($hasSubscription)
                        <div>
                            <h2 class="text-lg font-semibold mb-2">Subscription Details:</h2>
                            <p><strong>Plan:</strong> {{ $user->subscriptionPlan->name }}</p>
                            <p><strong>Expires At:</strong> {{ $user->subscription_expires_at }}</p>
                        </div>

                        @if ($subscriptionExpired)
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Alert!</strong>
                                <span class="block sm:inline"> Your subscription has ended. Please renew your subscription to continue accessing this feature.</span>
                            <a href="{{ route('subscription.form') }}" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Renew Subscription</a>
                            </div>
                        @else
                            <div class="mt-4">
                                <h2 class="text-lg font-semibold mb-2">Time Remaining:</h2>
                                <p>{{ $remainingTime }}</p>
                            </div>
                        @endif
                    @else
                        <p>No subscription found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
