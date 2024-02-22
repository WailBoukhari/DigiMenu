<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Restaurant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <form method="POST" action="{{ route('restaurant.profile.update', $restaurant->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Restaurant Name -->
                        <div class="mt-4">
                            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Restaurant Name') }}</label>
                            <input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $restaurant->name }}" required autofocus />
                        </div>

                        <!-- Address -->
                        <div class="mt-4">
                            <label for="address" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Address') }}</label>
                            <input id="address" class="block mt-1 w-full" type="text" name="address" value="{{ $restaurant->address }}" required />
                        </div>

                        <!-- Contact Number -->
                        <div class="mt-4">
                            <label for="contact_number" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Contact Number') }}</label>
                            <input id="contact_number" class="block mt-1 w-full" type="tel" name="contact_number" value="{{ $restaurant->contact_number }}" required />
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Description') }}</label>
                            <textarea id="description" class="block mt-1 w-full" name="description" rows="4">{{ $restaurant->description }}</textarea>
                        </div>

                        <!-- Image Upload -->
                        <div class="mt-4">
                            <label for="image" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Image') }}</label>
                            <input id="image" class="block mt-1 w-full" type="file" name="image" accept="image/*" />
                        </div>

                        <!-- Video Upload -->
                        <div class="mt-4">
                            <label for="video" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Video') }}</label>
                            <input id="video" class="block mt-1 w-full" type="file" name="video" accept="video/*" />
                        </div>

                        <!-- Other form fields for editing restaurant details -->

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
