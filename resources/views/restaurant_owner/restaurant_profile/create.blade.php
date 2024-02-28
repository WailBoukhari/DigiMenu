<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Restaurant') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
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

                <div class="p-6">
                    <form method="POST" action="{{ route('restaurant.profile.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Restaurant Name -->
                        <div class="mt-4">
                            <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Restaurant Name') }}</label>
                            <input id="name" type="text" name="name" :value="old('name')" required autofocus class="block w-full mt-1 py-2 px-3 border bg-gray-100 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Address -->
                        <div class="mt-4">
                            <label for="address" class="block font-medium text-sm text-gray-700">{{ __('Address') }}</label>
                            <input id="address" type="text" name="address" :value="old('address')" required class="block w-full mt-1 py-2 px-3 border bg-gray-100 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Contact Number -->
                        <div class="mt-4">
                            <label for="contact_number" class="block font-medium text-sm text-gray-700">{{ __('Contact Number') }}</label>
                            <input id="contact_number" type="tel" name="contact_number" :value="old('contact_number')" required class="block w-full mt-1 py-2 px-3 border bg-gray-100 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">{{ __('Description') }}</label>
                            <textarea id="description" name="description" rows="4" class="block w-full mt-1 py-2 px-3 border bg-gray-100 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">{{ __('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
