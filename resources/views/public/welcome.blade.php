<x-app-layout>
    <!-- Hero Section -->
    <div class="bg-indigo-700 text-white py-16 px-4 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">Welcome to EventHub</h1>
        <p class="mt-4 text-xl max-w-2xl mx-auto text-indigo-100">Discover, register, and manage your college and professional events seamlessly with dynamic billing and instant ticket generation.</p>
        <div class="mt-8">
            <a href="{{ route('public.events.index') }}" class="bg-white text-indigo-700 font-bold px-6 py-3 rounded-lg shadow hover:bg-indigo-50">Browse Events</a>
        </div>
    </div>

    <!-- Upcoming Events Section -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Upcoming Events</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($upcomingEvents ?? [] as $event)
                <div class="bg-white rounded-lg shadow p-6 flex flex-col justify-between">
                    <div>
                        <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded font-semibold">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</span>
                        <h3 class="text-xl font-bold mt-2 text-gray-900">{{ $event->title }}</h3>
                        <p class="text-gray-600 text-sm mt-2 line-clamp-2">{{ $event->description }}</p>
                    </div>
                    <div class="mt-6 flex justify-between items-center">
                        <span class="text-indigo-600 font-bold">₹{{ $event->registration_fee }}</span>
                        <a href="{{ route('events.show', $event->id) }}" class="bg-indigo-600 text-white text-sm px-4 py-2 rounded hover:bg-indigo-700">View Details</a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No upcoming events right now.</p>
            @endforelse
        </div>
    </div>

    <!-- How Registration Works -->
    <div class="bg-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">How Registration Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded shadow">
                    <div class="text-indigo-600 font-bold text-xl mb-2">1. Choose Event</div>
                    <p class="text-gray-600 text-sm">Browse our published events list and check available seats and workshop options.</p>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <div class="text-indigo-600 font-bold text-xl mb-2">2. Customize & Calculate</div>
                    <p class="text-gray-600 text-sm">Select your ticket count, workshops, and food packages with real-time billing calculations.</p>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <div class="text-indigo-600 font-bold text-xl mb-2">3. Get Ticket</div>
                    <p class="text-gray-600 text-sm">Instant confirmation generation with unique reference numbers and print options.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>