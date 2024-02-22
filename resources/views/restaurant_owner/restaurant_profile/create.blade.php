<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Restaurant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <form method="POST" action="{{ route('restaurant.profile.store') }}">
                        @csrf

                        <!-- Restaurant Name -->
                        <div class="mt-4">
                            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Restaurant Name') }}</label>
                            <input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        </div>

                        <!-- Address -->
                        <div class="mt-4">
                            <label for="address" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Address') }}</label>
                            <input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
                        </div>

                        <!-- Contact Number -->
                        <div class="mt-4">
                            <label for="contact_number" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Contact Number') }}</label>
                            <input id="contact_number" class="block mt-1 w-full" type="tel" name="contact_number" :value="old('contact_number')" required />
                        </div>

                        <!-- Other form fields for restaurant details -->

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">{{ __('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
