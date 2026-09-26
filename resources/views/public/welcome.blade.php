<x-public-layout>
<header class="bg-white border-b border-gray-200 sticky top-0 z-50">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-16 flex items-center gap-6">

        </div>
    </div>
<!-- Main -->
<main class="bg-gray-50 ">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">


        <!-- Breadcrumb -->
        <div class="text-xs text-gray-500 mb-4">

            <a href="{{ route('home') }}"
               class="hover:text-[#2874B8]">
                Home
            </a>

            <span class="mx-2">›</span>

            <a href="{{ route('public.events.index') }}"
               class="hover:text-[#2874B8]">
                Events
            </a>

        </div>




        <!-- Search & Filters -->
        <form method="GET"
              action="{{ route('public.events.index') }}"
              class="bg-white p-6 rounded-lg shadow-sm mb-8">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <!-- Search -->
                <div>

                    <label for="search"
                           class="block text-sm font-medium text-gray-700 mb-1">
                        Search
                    </label>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search events..."
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2874B8] focus:ring-[#2874B8]"
                    >

                </div>


                <!-- Date -->
                <div>

                    <label for="date"
                           class="block text-sm font-medium text-gray-700 mb-1">
                        Event Date
                    </label>

                    <input
                        type="date"
                        id="date"
                        name="date"
                        value="{{ request('date') }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2874B8] focus:ring-[#2874B8]"
                    >

                </div>


                <!-- Empty spacing -->
                <div class="hidden md:block"></div>


                <!-- Buttons -->
                <div class="flex items-end gap-2">

                    <button
                        type="submit"
                        class="flex-1 bg-[#2874B8] text-white px-4 py-2 rounded-md hover:bg-[#21669F] transition">
                        Search
                    </button>

                    <a
                        href="{{ route('home') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Reset
                    </a>

                </div>

            </div>

        </form>


        <!-- Page Title -->
        <div class="mb-7">

            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                Events in Kerala
            </h1>

            <p class="text-sm text-gray-500 mt-2">
                Discover the latest events, workshops and activities near you.
            </p>

        </div>
        
<div class="relative rounded-2xl overflow-hidden mb-8 bg-gradient-to-r from-blue-900 to-blue-700 text-white shadow-lg">

    <!-- Background Image Layer -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/hero.png') }}"
             alt="Hero Banner"
             class="w-full h-full object-cover opacity-40">
    </div>

    <!-- Content Layer (Keeps text above the background image) -->
    <div class="relative z-10 p-8 md:p-12 max-w-3xl">
        <span class="bg-blue-500/30 text-blue-200 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
            Welcome
        </span>

        <h1 class="text-3xl md:text-5xl font-extrabold mt-4 mb-3">
            Discover & Register for Amazing Events
        </h1>

        <p class="text-blue-100 text-sm md:text-base mb-6">
            Explore upcoming workshops, technical conferences, and meetups happening around you.
        </p>
    </div>

</div>


        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">


            <!-- Filters -->
            <aside class="bg-white rounded-lg border border-gray-200 h-fit">

                <div class="p-5 border-b border-gray-200 flex items-center justify-between">

                    <h2 class="font-bold text-gray-900">
                        Filters
                    </h2>

                    <a href="{{ route('home') }}"
                       class="text-xs text-[#2874B8] font-semibold hover:underline">
                        Clear All
                    </a>

                </div>


                <!-- Categories -->
                <div class="p-5 border-b border-gray-200">

                    <h3 class="text-sm font-semibold text-gray-900 mb-4">
                        Categories
                    </h3>

                    <div class="space-y-3 text-sm text-gray-600">

                        <label class="flex items-center gap-3 cursor-pointer">

                            <input
                                type="checkbox"
                                class="rounded border-gray-300 text-[#2874B8] focus:ring-[#2874B8]">

                            Music Shows

                        </label>


                        <label class="flex items-center gap-3 cursor-pointer">

                            <input
                                type="checkbox"
                                class="rounded border-gray-300 text-[#2874B8] focus:ring-[#2874B8]">

                            Workshops

                        </label>


                        <label class="flex items-center gap-3 cursor-pointer">

                            <input
                                type="checkbox"
                                class="rounded border-gray-300 text-[#2874B8] focus:ring-[#2874B8]">

                            Comedy Shows

                        </label>


                        <label class="flex items-center gap-3 cursor-pointer">

                            <input
                                type="checkbox"
                                class="rounded border-gray-300 text-[#2874B8] focus:ring-[#2874B8]">

                            Cultural

                        </label>


                        <label class="flex items-center gap-3 cursor-pointer">

                            <input
                                type="checkbox"
                                class="rounded border-gray-300 text-[#2874B8] focus:ring-[#2874B8]">

                            Technical

                        </label>

                    </div>

                </div>


                <!-- Date -->
                <div class="p-5 border-b border-gray-200">

                    <h3 class="text-sm font-semibold text-gray-900 mb-4">
                        Date
                    </h3>

                    <div class="space-y-3 text-sm text-gray-600">

                        <label class="flex items-center gap-3">

                            <input
                                type="checkbox"
                                class="rounded border-gray-300 text-[#2874B8]">

                            Today

                        </label>


                        <label class="flex items-center gap-3">

                            <input
                                type="checkbox"
                                class="rounded border-gray-300 text-[#2874B8]">

                            Tomorrow

                        </label>


                        <label class="flex items-center gap-3">

                            <input
                                type="checkbox"
                                class="rounded border-gray-300 text-[#2874B8]">

                            This Weekend

                        </label>


                        <label class="flex items-center gap-3">

                            <input
                                type="checkbox"
                                class="rounded border-gray-300 text-[#2874B8]">

                            Next Week

                        </label>

                    </div>

                </div>


                <!-- Price -->
                <div class="p-5">

                    <h3 class="text-sm font-semibold text-gray-900 mb-4">
                        Price
                    </h3>

                    <div class="space-y-3 text-sm text-gray-600">

                        <label class="flex items-center gap-3">

                            <input
                                type="checkbox"
                                class="rounded border-gray-300 text-[#2874B8]">

                            Under ₹500

                        </label>


                        <label class="flex items-center gap-3">

                            <input
                                type="checkbox"
                                class="rounded border-gray-300 text-[#2874B8]">

                            ₹500 - ₹1000

                        </label>


                        <label class="flex items-center gap-3">

                            <input
                                type="checkbox"
                                class="rounded border-gray-300 text-[#2874B8]">

                            ₹1000 - ₹2000

                        </label>


                        <label class="flex items-center gap-3">

                            <input
                                type="checkbox"
                                class="rounded border-gray-300 text-[#2874B8]">

                            ₹2000+

                        </label>

                    </div>

                </div>

            </aside>


            <!-- Events -->
            <section class="lg:col-span-3">


                <!-- Section Header -->
                <div class="flex items-center justify-between mb-5">

                    <div>

                        <h2 class="text-xl font-bold text-gray-900">
                            Upcoming Events
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Explore events happening around you
                        </p>

                    </div>


                    <select
                        class="hidden sm:block bg-white border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-600 focus:outline-none">

                        <option>Recommended</option>
                        <option>Date</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>

                    </select>

                </div>


                <!-- Event Grid -->
             <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">

@forelse(\App\Models\Event::all() as $event)

        <article class="bg-white rounded-lg overflow-hidden border border-gray-200 hover:shadow-lg transition duration-300">

            <!-- Keyword-based Poster Logic -->
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
            <!-- Card Body / Content -->
            <div class="p-5">
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $event->title }}</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $event->description }}</p>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-sm font-semibold text-blue-600">₹{{ $event->registration_fee }}</span>
                    
                    <a href="{{ route('public.events.show', $event) }}" 
                       class="px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-md hover:bg-blue-700 transition">
                        View Details
                    </a>
                </div>
            </div>

        </article>

    @empty
        <p class="text-gray-500 col-span-full text-center py-8">No upcoming events found.</p>
    @endforelse

</div>   

            </section>

        </div>


        

        <!-- About -->
        <section class="mt-16 bg-white border border-gray-200 rounded-lg p-8">

            <h2 class="text-xl font-bold text-gray-900 mb-3">
                Discover Events Near You
            </h2>

            <p class="text-sm leading-6 text-gray-600 max-w-4xl">

                EventHub helps you discover and register for college events,
                workshops, technical fests, cultural programs, sports events
                and other activities. Browse upcoming events, compare prices,
                customize your registration and get your ticket instantly.

            </p>

        </section>

    </div>

</main>


<!-- Footer -->
<footer class="bg-gray-900 text-gray-400 mt-16">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">


            <!-- Brand -->
            <div>

                <h3 class="text-xl font-black text-white">

                    <span class="text-[#2874B8]">
                        event
                    </span>hub

                </h3>

                <p class="text-sm mt-3 leading-6">

                    Discover and book events, workshops and experiences
                    around you.

                </p>

            </div>


            <!-- Events -->
            <div>

                <h4 class="text-white font-semibold mb-4">
                    Events
                </h4>

                <div class="space-y-2 text-sm">

                    <a href="#" class="block hover:text-white">
                        AI
                    </a>

                    <a href="#" class="block hover:text-white">
                       Cloud
                    </a>

                    <a href="#" class="block hover:text-white">
                        Full Stack
                    </a>

                    <a href="#" class="block hover:text-white">
                         ML
                    </a>

                </div>

            </div>


            <!-- Company -->
            <div>

                <h4 class="text-white font-semibold mb-4">
                    Company
                </h4>

                <div class="space-y-2 text-sm">

                    <a href="#" class="block hover:text-white">
                        About Us
                    </a>

                    <a href="#" class="block hover:text-white">
                        Contact Us
                    </a>

                    <a href="#" class="block hover:text-white">
                        List Your Event
                    </a>

                </div>

            </div>


            <!-- Support -->
            <div>

                <h4 class="text-white font-semibold mb-4">
                    Support
                </h4>

                <div class="space-y-2 text-sm">

                    <a href="#" class="block hover:text-white">
                        Help
                    </a>

                    <a href="#" class="block hover:text-white">
                        Terms & Conditions
                    </a>

                    <a href="#" class="block hover:text-white">
                        Privacy Policy
                    </a>

                </div>

            </div>

        </div> <!-- Copyright -->
        <div class="border-t border-gray-800 mt-10 pt-6 text-xs">

            © {{ date('Y') }} EventHub Systems. All rights reserved.

        </div>

    </div>

</footer>


<!-- </x-public-layout> -->
