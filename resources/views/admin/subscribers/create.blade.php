<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-300 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-800">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 bg-gray-900 rounded-lg">
                    <h2 class="text-2xl font-semibold text-white mb-4">Create Subscription Plan</h2>
                    <form method="POST" action="{{ route('admin.subscription.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-300 mb-2">Name:</label>
                            <input type="text" name="name" id="name"
                                class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-4 text-gray-200 focus:outline-none focus:border-blue-500" " required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-300 mb-2">Description:</label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-4 text-gray-200 focus:outline-none focus:border-blue-500"
                                required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="price" class="block text-gray-300 mb-2">Price:</label>
                            <input type="number" name="price" id="price" step="0.01" min="0" class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-4 text-gray-200 focus:outline-none focus:border-blue-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="scan_limit" class="block text-gray-300 mb-2">Scan Limit:</label>
                            <input type="number" name="scan_limit" id="scan_limit" class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-4 text-gray-200 focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="dish_creation_limit" class="block text-gray-300 mb-2">Dish Creation Limit:</label>
                            <input type="number" name="dish_creation_limit" id="dish_creation_limit" class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-4 text-gray-200 focus:outline-none focus:border-blue-500">
                        </div>
                        <!-- Add more fields as needed -->
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
