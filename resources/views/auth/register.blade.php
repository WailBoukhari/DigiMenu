<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-900">
        <form method="POST" action="{{ route('register') }}" class="w-full max-w-md p-8 bg-gray-800 rounded-lg shadow-lg">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" class="block mb-1 text-gray-300" />
                <x-text-input id="name" class="block w-full rounded-md bg-gray-700 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 dark:text-gray-300" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="block mb-1 text-gray-300" />
                <x-text-input id="email" class="block w-full rounded-md bg-gray-700 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 dark:text-gray-300" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" class="block mb-1 text-gray-300" />
                <x-text-input id="password" class="block w-full rounded-md bg-gray-700 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 dark:text-gray-300" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block mb-1 text-gray-300" />
                <x-text-input id="password_confirmation" class="block w-full rounded-md bg-gray-700 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 dark:text-gray-300" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <a class="text-sm text-gray-400 hover:text-gray-100" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ml-2 bg-blue-500 hover:bg-blue-700 focus:ring focus:ring-blue-200">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>

        <div class="mt-6">
            <form action="{{ route('google.redirect') }}" method="GET">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded inline-block transition duration-300 transform hover:scale-105 focus:ring focus:ring-red-300">Register with Google</button>
            </form>
        </div>
    </div>
</x-guest-layout>
