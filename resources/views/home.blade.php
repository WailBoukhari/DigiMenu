<x-guest-layout>
    <div class="bg-cover bg-center bg-gray-900 text-white py-20">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">DigiCodes - Digital Menu SaaS Platform</h1>
            <p class="text-lg mb-8">DigiCodes is a startup specializing in creating innovative and revolutionary SaaS solutions, aiming to develop a Digital Menu SaaS Platform that will offer an intuitive experience to restaurant owners. Create, customize, and share your digital menus with ease, while benefiting from secure authentication, real-time email notifications, and optimized performance.</p>
            @guest
                <!-- Redirect to register page -->
                <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block mb-2">Get Your Account Ready</a>
            @endguest
        </div>
    </div>
</x-guest-layout>
