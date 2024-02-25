<x-guest-layout>
    <!-- Banner section with restaurant name and description -->
    <div class="bg-gray-500 text-white py-20">
        <div class="container mx-auto text-center">
            <!-- Dynamic restaurant name and description -->
            <h1 class="text-4xl font-bold mb-4">{{ $restaurant->name }}</h1>
            <p class="text-lg mb-8">{{ $restaurant->description }}</p>
        </div>
    </div>

    <!-- Add padding to the container to increase spacing on left and right -->
    <div class="container mx-auto py-8 px-4 md:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- Menu section -->
        <div class="md:col-span-3">
            <h1 class="text-3xl font-semibold mb-4 text-white">{{ $restaurant->name }} Menu</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($menuItems as $menuItem)
                    <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                        <!-- Display menu item image -->
                        <img src="{{ $menuItem->getFirstMediaUrl('images') }}" alt="Menu Item Image" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <!-- Menu item details -->
                            <h2 class="text-xl font-semibold mb-2 text-white">{{ $menuItem->name }}</h2>
                            <p class="text-gray-300 mb-4">{{ $menuItem->description }}</p>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-400 font-bold">${{ $menuItem->price }}</p>
                                {{-- <button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md transition duration-300">Add to Cart</button> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Categories section -->
        <div class="md:col-span-1">
            <h2 class="text-3xl font-semibold mb-4 text-white">Categories</h2>
            <ul class="text-gray-300">
                {{-- @foreach ($categories as $category)
                    <li class="mb-2">
                        <a href="#" class="hover:text-gray-400">{{ $category->name }}</a>
                    </li>
                @endforeach --}}
            </ul>
        </div>
    </div>
</x-guest-layout>
