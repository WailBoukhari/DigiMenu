<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-8" :status="session('status')" />

    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
        <div class="w-full max-w-md bg-gray-800 rounded-lg shadow-lg p-8">
            <h2 class="text-white text-3xl font-bold mb-6">Login with Google</h2>
            <form action="{{ route('google.redirect') }}" method="GET">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full mb-4">Login with Google</button>
            </form>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="block mb-2 text-gray-300" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus class="block w-full rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 dark:bg-gray-900 dark:border-gray-700 dark:focus:border-red-600 dark:focus:ring-red-600 dark:text-gray-300" />
                    <x-input-error :messages="$errors->get('email')" class="text-red-500 mt-1" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="block mb-2 text-gray-300" />
                    <x-text-input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 dark:bg-gray-900 dark:border-gray-700 dark:focus:border-red-600 dark:focus:ring-red-600 dark:text-gray-300" />
                    <x-input-error :messages="$errors->get('password')" class="text-red-500 mt-1" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center text-gray-300">
                        <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-red-600 shadow-sm focus:ring-red-500 dark:focus:ring-red-600 dark:focus:ring-offset-gray-800" name="remember">
                        <span class="ml-2 text-sm">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-400 hover:text-white dark:text-gray-300 dark:hover:text-white" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button>
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
