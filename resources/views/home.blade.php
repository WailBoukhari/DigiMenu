<x-guest-layout>
    <!-- Hero Section -->
    <div class="bg-cover bg-center bg-gray-900 text-white py-20">
        <div class="container mx-auto text-center">
            <h1 class="text-5xl font-bold mb-8">DigiCodes - Your Digital Menu Solution</h1>
            <p class="text-lg mb-8">Welcome to DigiCodes, your all-in-one digital menu SaaS platform. Simplify your restaurant's operations with our intuitive digital menu solution. With DigiCodes, you can create stunning digital menus, customize them to match your brand, and effortlessly share them with your customers using QR codes.</p>
            <ul class="text-lg mb-8 text-left">
                <li class="mb-2 flex items-center text-gray-200"><span class="mr-2">&#10004;</span> Streamline your menu management process</li>
                <li class="mb-2 flex items-center text-gray-200"><span class="mr-2">&#10004;</span> Enhance customer experience with interactive menus</li>
                <li class="mb-2 flex items-center text-gray-200"><span class="mr-2">&#10004;</span> Increase efficiency with real-time updates</li>
                <li class="mb-2 flex items-center text-gray-200"><span class="mr-2">&#10004;</span> Ensure security with advanced authentication</li>
                <li class="mb-2 flex items-center text-gray-200"><span class="mr-2">&#10004;</span> Receive instant notifications via email</li>
                <li class="mb-2 flex items-center text-gray-200"><span class="mr-2">&#10004;</span> Optimize performance with our reliable platform</li>
            </ul>
            @guest
                <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded inline-block mb-2 transition duration-300 transform hover:scale-105">Get Started Today</a>
            @endguest
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="bg-white py-20">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold mb-12">How It Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="p-8 bg-gray-100 rounded-lg shadow-xl">
                    <img src="{{ asset('storage/demo.webp') }}" alt="Step 1" class="mx-auto mb-8 w-32 h-32">
                    <h3 class="text-2xl font-semibold mb-4">Create Your Menu</h3>
                    <p class="text-lg">Start by easily creating your digital menu using our user-friendly interface. Add categories, items, and customize the layout to suit your restaurant's style.</p>
                </div>
                <div class="p-8 bg-gray-100 rounded-lg shadow-xl">
                    <img src="{{ asset('storage/demo.webp') }}" alt="Step 2" class="mx-auto mb-8 w-32 h-32">
                    <h3 class="text-2xl font-semibold mb-4">Customize & Personalize</h3>
                    <p class="text-lg">Tailor your menu to reflect your brand identity. Choose from a variety of themes, colors, and fonts to create a unique and engaging experience for your customers.</p>
                </div>
                <div class="p-8 bg-gray-100 rounded-lg shadow-xl">
                    <img src="{{ asset('storage/demo.webp') }}" alt="Step 3" class="mx-auto mb-8 w-32 h-32">
                    <h3 class="text-2xl font-semibold mb-4">Share with QR Codes</h3>
                    <p class="text-lg">Generate QR codes for each menu and effortlessly share them with your customers. Simply display the QR code at your restaurant or include it in promotional materials.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Benefits Section -->
    <div class="bg-gray-900 text-white py-20">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold mb-12">Benefits of DigiCodes</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="p-8 bg-gray-800 rounded-lg shadow-xl">
                    <i class="fas fa-users fa-3x mb-6 text-blue-500"></i>
                    <h3 class="text-2xl font-semibold mb-4">Enhanced Customer Experience</h3>
                    <p class="text-lg">Provide your customers with an interactive and engaging menu experience, leading to increased satisfaction and loyalty.</p>
                </div>
                <div class="p-8 bg-gray-800 rounded-lg shadow-xl">
                    <i class="fas fa-cogs fa-3x mb-6 text-green-500"></i>
                    <h3 class="text-2xl font-semibold mb-4">Streamlined Operations</h3>
                    <p class="text-lg">Simplify your menu management process and reduce errors with our intuitive platform, saving you time and resources.</p>
                </div>
                <div class="p-8 bg-gray-800 rounded-lg shadow-xl">
                    <i class="fas fa-shield-alt fa-3x mb-6 text-yellow-500"></i>
                    <h3 class="text-2xl font-semibold mb-4">Secure & Reliable</h3>
                    <p class="text-lg">Rest easy knowing that your digital menus are protected with advanced authentication measures and hosted on a secure and reliable platform.</p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
