<x-public-layout>

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

    <div class="py-12">
        <div class="max-w-5xl mx-auto px-4">

            {{-- Event Poster Banner --}}
            <div class="h-80 w-full bg-gray-100 rounded-t-2xl overflow-hidden shadow-sm relative mb-[-1rem] z-10 border-b border-gray-200">
                <img src="{{ asset('images/' . $posterImage) }}" 
                     alt="{{ $event->title }}"
                     class="w-full h-full object-cover">
                     
                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md rounded-xl shadow px-4 py-3 text-center">
                    <div class="text-[#2874B8] font-bold text-xl leading-none">
                        {{ $event->event_date->format('d') }}
                    </div>
                    <div class="text-xs text-gray-600 font-semibold uppercase tracking-wider">
                        {{ $event->event_date->format('M') }}
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">

                <div class="bg-[#2874B8] text-white p-8 pt-10">
                    <div class="flex justify-between items-start gap-4">

                        <div>
                            <h1 class="text-3xl font-bold">
                                {{ $event->title }}
                            </h1>

                            <p class="mt-2 text-blue-100">
                                {{ $event->event_date->format('M d, Y h:i A') }}
                            </p>
                        </div>

                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                            {{ ucfirst($event->status) }}
                        </span>

                    </div>
                </div>

                <div class="p-8 space-y-8">

                    <div>
                        <h2 class="text-xl font-bold text-gray-900">
                            About This Event
                        </h2>

                        <p class="mt-3 text-gray-600 leading-relaxed">
                            {{ $event->description ?: 'No description available.' }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="bg-gray-50 rounded-lg p-5">
                            <p class="text-sm text-gray-500">
                                Registration Period
                            </p>

                            <p class="mt-2 font-semibold text-gray-900">
                                {{ $event->registration_start_date->format('M d, Y h:i A') }}
                                -
                                {{ $event->registration_end_date->format('M d, Y h:i A') }}
                            </p>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-5">
                            <p class="text-sm text-gray-500">
                                Available Seats
                            </p>

                            <p class="mt-2 text-2xl font-bold text-[#2874B8]">
                                {{ $event->available_seats }}
                                <span class="text-sm font-normal text-gray-500">
                                    / {{ $event->total_seats }}
                                </span>
                            </p>
                        </div>

                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-4">
                            Event Pricing
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                            <div class="border rounded-lg p-4">
                                <p class="text-sm text-gray-500">
                                    Registration
                                </p>
                                <p class="text-xl font-bold text-gray-900">
                                    ₹{{ number_format($event->registration_fee, 2) }}
                                </p>
                            </div>

                            <div class="border rounded-lg p-4">
                                <p class="text-sm text-gray-500">
                                    Workshop
                                </p>
                                <p class="text-xl font-bold text-gray-900">
                                    ₹{{ number_format($event->workshop_fee, 2) }}
                                </p>
                            </div>

                            <div class="border rounded-lg p-4">
                                <p class="text-sm text-gray-500">
                                    Food
                                </p>
                                <p class="text-xl font-bold text-gray-900">
                                    ₹{{ number_format($event->food_fee, 2) }}
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">

                        <a
                            href="{{ route('public.events.register', $event) }}"
                            class="flex-1 text-center bg-[#2874B8] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#1f5f96] transition"
                        >
                            Register Now
                        </a>

                        <a
                            href="{{ route('public.events.index') }}"
                            class="text-center bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition"
                        >
                            Back to Events
                        </a>

                    </div>

                </div>
            </div>

        </div>
    </div>

</x-public-layout>