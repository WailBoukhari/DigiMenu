<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Choose a Plan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($plans as $plan)
                    <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-lg sm:rounded-lg">
                        <div class="p-6">
                            <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-200">{{ $plan->name }}</h2>
                            <p class="text-gray-600 dark:text-gray-300 mb-2">{{ $plan->description }}</p>
                            <div class="flex flex-col mt-4">
                                <p class="text-gray-600 dark:text-gray-300">{{ __('Price: $') . $plan->price }}</p>
                                <p class="text-gray-600 dark:text-gray-300">{{ __('Scan Limit: ') . $plan->scan_limit }}</p>
                                <p class="text-gray-600 dark:text-gray-300">{{ __('Dish Creation Limit: ') . $plan->dish_creation_limit }}</p>
                            </div>
                            <form method="POST" action="{{ route('subscription.process') }}">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                <button type="submit" class="mt-6 bg-blue-500 dark:bg-blue-700 hover:bg-blue-600 dark:hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-md focus:outline-none focus:shadow-outline transition duration-300">
                                    {{ __('Select') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
