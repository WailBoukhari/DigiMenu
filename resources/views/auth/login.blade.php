<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-8" :status="session('status')" />

    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md bg-gray-800 rounded-lg shadow-lg p-8">
            <div class="text-center mb-6">
                <!-- Google Login Button -->
                <a href="{{ route('auth.google') }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-300">Login with Google</a>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" class="block mb-2 text-gray-300" />
                    <x-text-input id="email" class="block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 dark:text-gray-300" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="block mb-2 text-gray-300" />
                    <x-text-input id="password" class="block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 dark:text-gray-300" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center text-gray-300">
                        <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                        <span class="ml-2 text-sm">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100" href="{{ route('password.request') }}">
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
