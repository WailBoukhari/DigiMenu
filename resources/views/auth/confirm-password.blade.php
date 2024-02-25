<x-guest-layout>
    <div class="mb-8 text-sm text-gray-600 dark:text-gray-400 text-center">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="max-w-md mx-auto">
        @csrf

        <!-- Password -->
        <div class="mb-6">
            <x-input-label for="password" :value="__('Password')" class="block mb-1 text-gray-700 dark:text-gray-300 text-sm" />

            <x-text-input id="password" class="block w-full px-4 py-2 rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300 border border-gray-300 dark:border-gray-600 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 dark:text-red-400 text-xs" />
        </div>

        <div class="flex justify-center">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
