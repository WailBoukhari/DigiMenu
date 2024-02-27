<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 dark:text-gray-800 leading-tight">
            {{ __('Create Restaurant') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
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
                <div class="p-6 bg-gray-900 dark:bg-gray-800 border-b border-gray-700 dark:border-gray-600">
                    <form method="POST" action="{{ route('restaurant.profile.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Restaurant Name -->
                        <div class="mt-4">
                            <label for="name" class="block font-medium text-sm text-gray-300 dark:text-gray-400">{{ __('Restaurant Name') }}</label>
                            <input id="name" class="block w-full mt-1 py-2 px-3 bg-gray-700 dark:bg-gray-600 border border-gray-600 dark:border-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-200 dark:text-gray-300 rounded-md" type="text" name="name" :value="old('name')" required autofocus />
                        </div>

                        <!-- Address -->
                        <div class="mt-4">
                            <label for="address" class="block font-medium text-sm text-gray-300 dark:text-gray-400">{{ __('Address') }}</label>
                            <input id="address" class="block w-full mt-1 py-2 px-3 bg-gray-700 dark:bg-gray-600 border border-gray-600 dark:border-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-200 dark:text-gray-300 rounded-md" type="text" name="address" :value="old('address')" required />
                        </div>

                        <!-- Contact Number -->
                        <div class="mt-4">
                            <label for="contact_number" class="block font-medium text-sm text-gray-300 dark:text-gray-400">{{ __('Contact Number') }}</label>
                            <input id="contact_number" class="block w-full mt-1 py-2 px-3 bg-gray-700 dark:bg-gray-600 border border-gray-600 dark:border-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-200 dark:text-gray-300 rounded-md" type="tel" name="contact_number" :value="old('contact_number')" required />
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <label for="description" class="block font-medium text-sm text-gray-300 dark:text-gray-400">{{ __('Description') }}</label>
                            <textarea id="description" class="block w-full mt-1 py-2 px-3 bg-gray-700 dark:bg-gray-600 border border-gray-600 dark:border-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-200 dark:text-gray-300 rounded-md" name="description" rows="4" required>{{ old('description') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">{{ __('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
