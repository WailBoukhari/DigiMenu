<x-guest-layout>
    <!-- Hero Section -->
    <div class="bg-gray-900 text-white py-20">
        <div class="container mx-auto text-center px-4 md:px-8">
            <h1 class="text-5xl font-extrabold mb-8 tracking-wider">{{ $restaurant->name }}</h1>
            <p class="text-lg mb-10 italic">{{ $restaurant->description }}</p>
            @if ($restaurant->qr_code_path)
                <div class="mb-10">
                    <h2 class="text-2xl font-semibold mb-4">Scan to Explore</h2>
                    <img src="{{ asset('storage/' . $restaurant->qr_code_path) }}" alt="QR Code" class="w-48 h-48 m-auto shadow-lg rounded-lg">
                </div>
            @endif
        </div>
    </div>

    <!-- Menu Section -->
    <div class="bg-gray-100 py-20">
        <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 px-4 md:px-8">
            @foreach ($menuItems as $menuItem)
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-2">
                    <div class="relative">
                        <img src="{{ $menuItem->getFirstMediaUrl('images') }}" alt="Menu Item Image" class="w-full h-60 object-cover rounded-t-lg">
                        @if ($menuItem->new)
                            <div class="absolute top-0 right-0 p-2 bg-yellow-500 text-white font-semibold rounded-bl-lg rounded-tr-lg">New</div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2 text-gray-900">{{ $menuItem->name }}</h2>
                        <p class="text-gray-700 mb-4">{{ $menuItem->description }}</p>
                        <div class="flex justify-between items-center">
                            <p class="text-gray-900 font-bold">${{ $menuItem->price }}</p>
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-300 transform hover:scale-105">Add to Cart</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Categories Section -->
    <div class="bg-gray-800 text-white py-20">
        <div class="container mx-auto">
            <h2 class="text-3xl font-semibold mb-6 text-center">Categories</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($menuItems->pluck('category')->unique() as $category)
                    <div class="text-center py-3 px-6 bg-gray-700 rounded-md hover:bg-gray-600 transition duration-300 transform hover:scale-105">{{ $category }}</div>
                @endforeach
            </div>
        </div>
    </div>
</x-guest-layout>
