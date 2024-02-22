<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Dash') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($hasSubscription)
                        <div>
                            <h2 class="text-lg font-semibold mb-2 text-gray-200">Subscription Details:</h2>
                            <p class="text-gray-300"><strong>Plan:</strong> {{ $user->subscriptionPlan->name }}</p>
                            <p class="text-gray-300"><strong>Expires At:</strong> {{ $user->subscription_expires_at }}</p>
                        </div>

                        @if ($subscriptionExpired)
                            <div class="bg-red-700 border border-red-900 text-red-100 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Alert!</strong>
                                <span class="block sm:inline"> Your subscription has ended. Please renew your subscription to continue accessing this feature.</span>
                                <a href="{{ route('subscription.form') }}" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Renew Subscription</a>
                            </div>
                        @else
                            <div class="mt-4">
                                <h2 class="text-lg font-semibold mb-2 text-gray-200">Time Remaining:</h2>
                                <p class="text-gray-300">{{ $remainingTime }}</p>
                            </div>
                        @endif
                    @else
                        <p class="text-gray-300">No subscription found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
