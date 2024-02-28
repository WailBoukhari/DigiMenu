<x-app-layout>
      <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Menu') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <div class="p-6 bg-gray-900 dark:bg-gray-800 border-b border-gray-700 dark:border-gray-600">
                    <h1 class="text-2xl mb-4 text-gray-200 dark:text-gray-300">Add New Menu Item</h1>
                    <form action="{{ route('restaurant.menus.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-bold mb-2 text-gray-300 dark:text-gray-400">Name</label>
                            <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
