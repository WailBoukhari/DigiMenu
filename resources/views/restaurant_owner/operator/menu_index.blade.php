<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-300 leading-tight">
            {{ __('Operator Menus') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto container">
            @if ($subscriptionExpired)
                <!-- Display message -->
                <div class="bg-red-600 border border-red-700 text-white px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">{{ $message }}</strong>
                </div>
            @else
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gray-700 border-b border-gray-600">
                        <div class="flex justify-end mb-4">
                            <!-- Add new menu button -->
                            <a href="{{ route('restaurant.menus.create') }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add New
                                Menu</a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-6 py-3 bg-gray-600 text-left text-sm font-medium text-gray-300 uppercase">
                                            Menu Name
                                        </th>
                                        <th
                                            class="px-6 py-3 bg-gray-600 text-left text-sm font-medium text-gray-300 uppercase">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                               <tbody class="bg-gray-800 divide-y divide-gray-600">
                                    @foreach ($menus as $menu)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                {{ $menu->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <!-- Edit menu button -->
                                                <a href="{{ route('restaurant.menus.edit', $menu->id) }}"
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                                                <!-- Delete menu button -->
                                                <form action="{{ route('restaurant.menus.destroy', $menu->id) }}"
                                                    method="POST" class="inline">
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
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
