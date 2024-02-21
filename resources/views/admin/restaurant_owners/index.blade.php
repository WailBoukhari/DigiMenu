<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Restaurant Owners and Subscription Plans') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @foreach ($restaurantOwners as $owner)
                        <div class="mb-4">
                            <p><strong>Owner Name:</strong> {{ $owner->name }}</p>
                            @if ($owner->subscriptionPlan)
                                <p><strong>Subscription Plan:</strong> {{ $owner->subscriptionPlan->name }}</p>
                            @else
                                <p>No Subscription Plan</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
