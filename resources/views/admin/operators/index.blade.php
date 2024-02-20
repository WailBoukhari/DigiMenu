<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Operators') }}</h2>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($operators as $operator)
                            <li class="py-4">
                                <p class="text-gray-900 dark:text-gray-100">{{ $operator->name }}</p>
                                <p class="text-gray-600 dark:text-gray-300">{{ $operator->email }}</p>
                                
                                <p class="text-gray-600 dark:text-gray-300">{{ __('Restaurants:') }}</p>
                                <ul>
                                    @foreach ($operator->restaurants as $restaurant)
                                        <li>{{ $restaurant->name }}</li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
