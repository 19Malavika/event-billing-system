<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


<title>{{ config('app.name', 'EventHub') }}</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="bg-gray-50 text-gray-900">


<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <a href="{{ route('home') }}"
               class="text-xl font-bold text-indigo-600">
                EventHub
            </a>

            <nav class="flex items-center gap-6">

                <a href="{{ route('home') }}"
                   class="text-gray-600 hover:text-indigo-600">
                    Home
                </a>

                <a href="{{ route('public.events.index') }}"
                   class="text-gray-600 hover:text-indigo-600">
                    Events
                </a>

                <a href="{{ route('login') }}"
                   class="text-gray-600 hover:text-indigo-600">
                    Admin Login
                </a>

            </nav>

        </div>
    </div>
</header>

<main>
    {{ $slot }}
</main>

<footer class="bg-gray-900 text-gray-300 py-6 mt-12">
    <div class="max-w-7xl mx-auto px-4 text-center text-sm">
        © {{ date('Y') }} EventHub. All rights reserved.
    </div>
</footer>


</body>

</html>
