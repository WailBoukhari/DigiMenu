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
                                      @if(session()->has('success'))
                        <div class="bg-green-500 text-white p-4 mb-6">
                            {{ session()->get('success') }}
                        </div>
                    @endif

                    @if(session()->has('error'))
                        <div class="bg-red-500 text-white p-4 mb-6">
                            {{ session()->get('error') }}
                        </div>
                    @endif

                    <h2 class="text-lg font-semibold mb-4 text-gray-200">{{ __('Operators') }}</h2>
                    <ul class="divide-y divide-gray-600 dark:divide-gray-700">
                        @foreach ($operators as $operator)
                            <li class="py-4">
                                <p class="text-lg font-semibold mb-1 text-gray-300 dark:text-gray-100">
                                    {{ $operator->name }}
                                </p>
                                <p class="text-gray-400 dark:text-gray-300">{{ $operator->email }}</p>

                                <p class="text-gray-400 dark:text-gray-300 mt-2">{{ __('Owner:') }}</p>
                                @if ($operator->restaurants && $operator->restaurants->isNotEmpty())
                                    @foreach ($operator->restaurants as $restaurant)
                                        <p class="text-gray-400 dark:text-gray-300 ml-4">
                                            @if ($restaurant->owner)
                                                {{ $restaurant->owner->name }}
                                            @else
                                                {{ __('Unknown') }}
                                            @endif
                                        </p>
                                    @endforeach
                                @else
                                    <p class="text-gray-400 dark:text-gray-300 ml-4">{{ __('No associated owner') }}</p>
                                @endif

                                <p class="text-gray-400 dark:text-gray-300 mt-2">{{ __('Restaurant:') }}</p>
                                @if ($operator->restaurants && $operator->restaurants->isNotEmpty())
                                    <ul>
                                        @foreach ($operator->restaurants as $restaurant)
                                            <li class="text-gray-400 dark:text-gray-300 ml-4">{{ $restaurant->name }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-400 dark:text-gray-300 ml-4">{{ __('No associated restaurants') }}</p>
                                @endif

                                <form action="{{ route('remove.operator.role', ['id' => $operator->id]) }}"
                                      method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="mt-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        {{ __('Remove Operator Role') }}
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
