<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-lg font-semibold mb-4 text-gray-200">{{ __('Operators') }}</h2>
                    <ul class="divide-y divide-gray-600 dark:divide-gray-700">
                        @foreach ($operators as $operator)
                            <li class="py-4">
                                <p class="text-lg font-semibold mb-1 text-gray-300 dark:text-gray-100">{{ $operator->name }}</p>
                                <p class="text-gray-400 dark:text-gray-300">{{ $operator->email }}</p>
                                
                                <p class="text-gray-400 dark:text-gray-300 mt-2">{{ __('Restaurants:') }}</p>
                                <ul>
                                    @foreach ($operator->restaurants as $restaurant)
                                        <li class="text-gray-400 dark:text-gray-300 ml-4">{{ $restaurant->name }}</li>
                                    @endforeach
                                </ul>

                                <div class="flex mt-4">
                                    <a href="{{ route('edit.operator', $operator->id) }}" class="bg-blue-500 dark:bg-blue-700 hover:bg-blue-600 dark:hover:bg-blue-800 text-white font-bold py-2 px-4 rounded mr-2">
                                        {{ __('Edit') }}
                                    </a>

                                    <form action="{{ route('remove.operator.role', $operator->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-red-500 dark:bg-red-700 hover:bg-red-600 dark:hover:bg-red-800 text-white font-bold py-2 px-4 rounded">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
