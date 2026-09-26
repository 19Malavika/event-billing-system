<x-public-layout>

    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800">
                Explore Events
            </h2>

            <p class="mt-2 text-gray-600">
                Find an event and register for your preferred event.
            </p>
        </div>


        <!-- Search & Filters -->
        <form
            method="GET"
            action="{{ route('public.events.index') }}"
            class="bg-white p-6 rounded-lg shadow-sm mb-8"
        >

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <!-- Search -->
                <div>

                    <label
                        for="search"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Search
                    </label>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search events..."
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >

                </div>


                <!-- Status -->
                <div>

                    <label
                        for="status"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >

                        <option value="">
                            All Status
                        </option>

                        <option
                            value="published"
                            {{ request('status') === 'published' ? 'selected' : '' }}
                        >
                            Published
                        </option>

                        <option
                            value="draft"
                            {{ request('status') === 'draft' ? 'selected' : '' }}
                        >
                            Draft
                        </option>

                    </select>

                </div>


                <!-- Date -->
                <div>

                    <label
                        for="date"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Event Date
                    </label>

                    <input
                        type="date"
                        id="date"
                        name="date"
                        value="{{ request('date') }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >

                </div>


                <!-- Buttons -->
                <div class="flex items-end gap-2">

                    <button
                        type="submit"
                        class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700"
                    >
                        Search
                    </button>

                    <a
                        href="{{ route('public.events.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                    >
                        Reset
                    </a>

                </div>

            </div>

        </form>


        <!-- Events Section (BookMyShow Vertical Grid) -->
        <div class="mb-8">

            <!-- Section Header -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">
                    Upcoming Events
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Browse all available events and secure your spot
                </p>
            </div>


            <!-- Vertical Grid Layout -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">

                @forelse($events as $event)

                    <!-- Event Card -->
                    <div class="bg-white rounded-xl overflow-hidden flex flex-col group cursor-pointer border border-gray-100 shadow-sm hover:shadow-md transition">

                       <!-- Tall Portrait Poster Image Container -->
<div class="relative w-full aspect-[3/4] bg-gray-100 overflow-hidden">
    
@php
    $title = strtolower($event->title);
    $posterImage = 'tech.jpeg'; // Absolute fallback

    if (str_contains($title, 'cloud') || str_contains($title, 'devops')) {
        $posterImage = 'cloudand devops.jpeg';
    } elseif (str_contains($title, 'full-stack') || str_contains($title, 'ai') || str_contains($title, 'development')) {
        $posterImage = 'Ai and fullstack.png';
    } elseif (str_contains($title, 'embedded') || str_contains($title, 'iot')) {
        $posterImage = 'embedded systems.jpeg';
    } elseif (str_contains($title, 'innovators') || str_contains($title, 'meetup')) {
        $posterImage = 'techinnovaters.jpg';
    } elseif (str_contains($title, 'tech summit')) {
        $posterImage = 'tech.jpeg';
    } elseif (str_contains($title, 'music') || str_contains($title, 'kochi live') || str_contains($title, 'indie')) {
        $posterImage = 'music.jpeg';
    } elseif (str_contains($title, 'comedy') || str_contains($title, 'comics') || str_contains($title, 'stand-up')) {
        $posterImage = 'comedy.jpg';
    } elseif (str_contains($title, 'cultural') || str_contains($title, 'dance') || str_contains($title, 'traditional')) {
        $posterImage = 'cultural.jpeg';
    } elseif (str_contains($title, 'silent disco') || str_contains($title, 'neon')) {
        $posterImage = 'silent_disco.webp';
    } elseif (str_contains($title, 'food') || str_contains($title, 'brew') || str_contains($title, 'festival')) {
        $posterImage = 'food_fest.jpeg';
    } elseif (str_contains($title, 'midnight cinema') || str_contains($title, 'stargazing') || str_contains($title, 'open-air')) {
        $posterImage = 'midnight_cinema.jpeg';
    } elseif (str_contains($title, 'pottery') || str_contains($title, 'clay') || str_contains($title, 'sculpting')) {
        $posterImage = 'pottery_class.jpg';
    } elseif (str_contains($title, 'board game') || str_contains($title, 'strategy') || str_contains($title, 'gaming')) {
        $posterImage = 'board_game.jpeg';
    } elseif (str_contains($title, 'workshop') || str_contains($title, 'masterclass')) {
        $posterImage = 'workshop.jpeg';
    }
@endphp

<div class="relative w-full h-52 bg-gray-900 flex items-center justify-center overflow-hidden rounded-t-xl">
    <img src="{{ asset('images/' . rawurlencode($posterImage)) }}" 
         alt="{{ $event->title }}" 
         class="w-full h-full object-cover transition duration-300">
</div>
</div> 

                        <!-- Card Details -->
                        <div class="p-3 flex flex-col flex-1 justify-between">

                            <div>
                                <!-- Event Date -->
                                <p class="text-[11px] font-bold text-indigo-600 uppercase tracking-wider mb-1">
                                    {{ $event->event_date?->format('D, M d • h:i A') }}
                                </p>

                                <!-- Event Title -->
                                <h3 class="text-sm font-bold text-gray-900 line-clamp-1 group-hover:text-indigo-600 transition">
                                    {{ $event->title }}
                                </h3>

                                <!-- Available Seats -->
                                <p class="text-xs text-gray-500 mt-1">
                                    Seats: <span class="font-semibold text-indigo-600">{{ $event->available_seats }} / {{ $event->total_seats }}</span>
                                </p>
                            </div>


                            <!-- Bottom Price & Action -->
                            <div class="mt-3 pt-2 border-t border-gray-100 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-gray-400 block">Fee</span>
                                    <span class="text-xs font-bold text-gray-900">
                                        ₹{{ number_format($event->registration_fee, 2) }}
                                    </span>
                                </div>

                                <a
                                    href="{{ route('public.events.show', $event) }}"
                                    class="bg-indigo-600 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-indigo-700 transition"
                                >
                                    View
                                </a>
                            </div>

                        </div>

                    </div>

                @empty

                    <!-- Empty State -->
                    <div class="col-span-full bg-white rounded-lg shadow-sm p-10 text-center">

                        <h3 class="text-lg font-semibold text-gray-800">
                            No events found
                        </h3>

                        <p class="text-gray-500 mt-2">
                            Try changing your search or filters.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>


        <!-- Pagination -->
        <div class="mt-8">
            {{ $events->links() }}
        </div>

    </div>

</x-public-layout>