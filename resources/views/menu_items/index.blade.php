<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Menu Items') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($subscriptionExpired)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <strong class="font-bold">Your subscription has expired!</strong>
                    <span class="block sm:inline">Please renew your subscription to continue.</span>
                    <a href="{{ route('subscription.form') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block mt-3">Renew
                        Subscription</a>
                </div>
            @else
                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                        <a href="{{ route('menu-items.create') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-3 inline-block">Add
                            New Menu Item</a>

                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-600 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-600 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-600 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Price
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-600 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-700 dark:divide-gray-600">
                                @foreach ($menuItems as $menuItem)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            {{ $menuItem->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            {{ $menuItem->description }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            {{ $menuItem->price }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <a href="{{ route('menu-items.edit', $menuItem->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            <form action="{{ route('menu-items.destroy', $menuItem->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this item?')"
                                                    class="text-red-600 hover:text-red-900">Delete</button>
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
