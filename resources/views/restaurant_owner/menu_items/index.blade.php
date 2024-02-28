<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-300 leading-tight">
            {{ __('Menu Items') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 dark:bg-gray-800">
        <div class="container mx-auto">
            <!-- Your existing content -->
            <!-- Check if subscription expired -->
            @if ($subscriptionExpired)
                <!-- Subscription expired message and renewal button -->
                <div class="bg-red-600 border border-red-700 text-white px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Your subscription has expired!</strong>
                    <span class="block sm:inline">Please renew your subscription to continue.</span>
                    <a href="{{ route('subscription.form') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block mt-3">Renew
                        Subscription</a>
                </div>
            @else
                <!-- Display success and error messages -->
                @if (session()->has('success'))
                    <div class="bg-green-500 dark:bg-green-600 text-white p-4 mb-6">
                        {{ session()->get('success') }}
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="bg-red-500 dark:bg-red-600 text-white p-4 mb-6">
                        {{ session()->get('error') }}
                    </div>
                @endif

                <!-- Add New Menu Item button -->
                <div class="flex justify-end mb-4">
                    <a href="{{ route('restaurant.menu.create') }}"
                        @if ($menuItems->count() >= $subscriptionPlan->dish_creation_limit) disabled
            onclick="return false;"
            class="bg-blue-600 dark:bg-blue-700 opacity-50 cursor-not-allowed text-white font-bold py-2 px-4 rounded"
        @else
            class="bg-blue-600 dark:bg-blue-700 hover:bg-blue-800 dark:hover:bg-blue-800 text-white font-bold py-2 px-4 rounded" @endif>
                        Add New Menu Item
                    </a>
                </div>

                <!-- Display menu items -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 bg-gray-600 dark:bg-gray-700 text-left text-sm font-medium text-gray-300 dark:text-gray-200 uppercase tracking-wider">
                                    Name
                                </th>
                                <th
                                    class="px-6 py-3 bg-gray-600 dark:bg-gray-700 text-left text-sm font-medium text-gray-300 dark:text-gray-200 uppercase tracking-wider">
                                    Description
                                </th>
                                <th
                                    class="px-6 py-3 bg-gray-600 dark:bg-gray-700 text-left text-sm font-medium text-gray-300 dark:text-gray-200 uppercase tracking-wider">
                                    Price
                                </th>
                                <th
                                    class="px-6 py-3 bg-gray-600 dark:bg-gray-700 text-left text-sm font-medium text-gray-300 dark:text-gray-200 uppercase tracking-wider">
                                    Menu
                                </th>
                                <th
                                    class="px-6 py-3 bg-gray-600 dark:bg-gray-700 text-left text-sm font-medium text-gray-300 dark:text-gray-200 uppercase tracking-wider">
                                    Category
                                </th>
                                <th
                                    class="px-6 py-3 bg-gray-600 dark:bg-gray-700 text-left text-sm font-medium text-gray-300 dark:text-gray-200 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 dark:bg-gray-600 divide-y divide-gray-600">
                            @foreach ($menuItems as $menuItem)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 dark:text-gray-200">
                                        {{ $menuItem->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 dark:text-gray-200">
                                        {{ $menuItem->description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 dark:text-gray-200">
                                        {{ $menuItem->price }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 dark:text-gray-200">
                                        {{ $menuItem->menu->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 dark:text-gray-200">
                                        {{ $menuItem->category }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <!-- Edit menu button -->
                                        <a href="{{ route('restaurant.menu.edit', $menuItem->id) }}"
                                            class="bg-blue-500 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-800 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                                        <!-- Delete menu button -->
                                        <form action="{{ route('restaurant.menu.destroy', $menuItem->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 dark:bg-red-600 hover:bg-red-700 dark:hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            @endif
        </div>
    </div>
</x-app-layout>
