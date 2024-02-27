<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                        <div>
                        <label for="name" class="block font-medium text-gray-700 dark:text-gray-300">{{ __('Name') }}</label>
                        <input id="name" class="block mt-1 w-full rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:focus:ring-blue-500 dark:focus:border-blue-500 sm:text-sm" type="text" name="name" value="{{ $user->name }}" required autofocus />
                    </div>

                    <div class="mt-4">
                        <label for="email" class="block font-medium text-gray-700 dark:text-gray-300">{{ __('Email') }}</label>
                        <input id="email" class="block mt-1 w-full rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:focus:ring-blue-500 dark:focus:border-blue-500 sm:text-sm" type="email" name="email" value="{{ $user->email }}" required />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="bg-blue-500 dark:bg-blue-700 hover:bg-blue-600 dark:hover:bg-blue-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            {{ __('Update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
