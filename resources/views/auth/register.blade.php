<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen">
        <form method="POST" action="{{ route('register') }}" class="w-full max-w-md p-6 bg-gray-800 rounded-lg shadow-lg">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" class="block mb-1 text-gray-300" />
                <x-text-input id="name" class="block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 dark:text-gray-300" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="block mb-1 text-gray-300" />
                <x-text-input id="email" class="block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 dark:text-gray-300" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" class="block mb-1 text-gray-300" />
                <x-text-input id="password" class="block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 dark:text-gray-300" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block mb-1 text-gray-300" />
                <x-text-input id="password_confirmation" class="block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 dark:text-gray-300" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button>
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
