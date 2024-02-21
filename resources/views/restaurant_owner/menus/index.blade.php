<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Menus') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($subscriptionExpired)
                <!-- Subscription expired message -->
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <strong class="font-bold">Your subscription has expired!</strong>
                    <span class="block sm:inline">Please renew your subscription to continue.</span>
                    <!-- Renewal button -->
                    <a href="{{ route('subscription.form') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block mt-3">Renew
                        Subscription</a>
                </div>
            @else
                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                        <div class="flex justify-end mb-4">
                            <!-- Add new menu button -->
                            <a href="{{ route('restaurant.menus.create') }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add New
                                Menu</a>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-600 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Menu Name
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-600 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-700 dark:divide-gray-600">
                                @foreach ($menus as $menu)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            {{ $menu->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <!-- Edit menu button -->
                                            <a href="{{ route('restaurant.menus.edit', $menu->id) }}"
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                                            <!-- Delete menu button -->
                                            <form action="{{ route('restaurant.menus.destroy', $menu->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
