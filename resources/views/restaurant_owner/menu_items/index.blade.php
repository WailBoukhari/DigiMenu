<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 dark:text-gray-800 leading-tight">
            {{ __('Menu Items') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($subscriptionExpired)
                <!-- Subscription expired message and renewal button -->
                <div class="bg-red-300 border border-red-200 text-white px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Your subscription has expired!</strong>
                    <span class="block sm:inline">Please renew your subscription to continue.</span>
                    <a href="{{ route('subscription.form') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block mt-3">Renew
                        Subscription</a> 
                </div>
            @else
                @if ($menuItems->isEmpty())
                    <!-- No menu items message -->
                    <p class="text-gray-400 dark:text-gray-300">No menu items available.</p>
                @else
                    <!-- Render the table with menu items -->
                    <div class="bg-gray-800 dark:bg-gray-600 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-gray-800 dark:bg-gray-600 border-b border-gray-600 dark:border-gray-700">
                            <!-- Add New Menu Item button -->
                            <a href="{{ route('restaurant.menu.create') }}"
                                class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded mb-3 inline-block">Add
                                New Menu Item</a>

                            <!-- Menu Items table -->
                            <table class="min-w-full divide-y divide-gray-600 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-6 py-3 bg-gray-700 dark:bg-gray-500 text-left text-xs leading-4 font-medium text-gray-300 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th
                                            class="px-6 py-3 bg-gray-700 dark:bg-gray-500 text-left text-xs leading-4 font-medium text-gray-300 uppercase tracking-wider">
                                            Description
                                        </th>
                                        <th
                                            class="px-6 py-3 bg-gray-700 dark:bg-gray-500 text-left text-xs leading-4 font-medium text-gray-300 uppercase tracking-wider">
                                            Price
                                        </th>
                                        <th
                                            class="px-6 py-3 bg-gray-700 dark:bg-gray-500 text-left text-xs leading-4 font-medium text-gray-300 uppercase tracking-wider">
                                            Menu
                                        </th>
                                        <th
                                            class="px-6 py-3 bg-gray-700 dark:bg-gray-500 text-left text-xs leading-4 font-medium text-gray-300 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-700 dark:bg-gray-500 divide-y divide-gray-600 dark:divide-gray-700">
                                    @foreach ($menuItems as $menuItem)
                                        <!-- Render menu items related to the authenticated user -->
                                        @if ($menuItem->menu->user_id === auth()->id())
                                            <tr>
                                                <td class="px-6 py-4 whitespace-no-wrap text-gray-200 dark:text-gray-800">
                                                    {{ $menuItem->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-no-wrap text-gray-200 dark:text-gray-800">
                                                    {{ $menuItem->description }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-no-wrap text-gray-200 dark:text-gray-800">
                                                    {{ $menuItem->price }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-no-wrap text-gray-200 dark:text-gray-800">
                                                    {{ $menuItem->menu->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-no-wrap text-gray-200 dark:text-gray-800">
                                                    <!-- Edit button -->
                                                    <a href="{{ route('restaurant.menu.edit', $menuItem->id) }}"
                                                        class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                                                    <!-- Delete button -->
                                                    <form action="{{ route('restaurant.menu.destroy', $menuItem->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            onclick="return confirm('Are you sure you want to delete this item?')"
                                                            class="text-red-600 hover:text-red-800">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
