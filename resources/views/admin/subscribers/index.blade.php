<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-800 shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-gray-800 border-b border-gray-700">
                    <div class="text-2xl mb-8">
                        <h2 class="text-3xl font-bold text-white">Subscription Plans</h2>
                        <a href="{{ route('admin.subscription.create') }}" class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mt-4">Add New Plan</a>
                    </div>

                    @if ($subscriptionPlans->count() > 0)
                        <table class="table-auto w-full text-white">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 bg-gray-700">ID</th>
                                    <th class="px-4 py-2 bg-gray-700">Name</th>
                                    <th class="px-4 py-2 bg-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscriptionPlans as $plan)
                                    <tr class="border-t border-gray-700">
                                        <td class="px-4 py-2">{{ $plan->id }}</td>
                                        <td class="px-4 py-2">{{ $plan->name }}</td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('admin.subscription.edit', $plan->id) }}" class="inline-block px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</a>
                                            <form action="{{ route('admin.subscription.destroy', $plan->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-400">No subscription plans found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
