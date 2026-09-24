<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Event Registration System') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-slate-300 hidden md:flex flex-col shadow-lg">
            <div class="h-16 flex items-center px-6 bg-slate-950 text-white font-bold text-lg tracking-wider">
                EventHub Admin
            </div>
            <nav class="flex-1 px-4 py-6 space-y-1 text-sm font-medium">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : '' }}">Dashboard</a>
                <a href="{{ route('events.index') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition {{ request()->routeIs('events.*') ? 'bg-indigo-600 text-white' : '' }}">Events</a>
                <a href="{{ route('participants.index') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition {{ request()->routeIs('participants.*') ? 'bg-indigo-600 text-white' : '' }}">Participants</a>
                <a href="{{ route('registrations.index') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition {{ request()->routeIs('registrations.*') ? 'bg-indigo-600 text-white' : '' }}">Registrations</a>
                <a href="{{ route('reports.revenue') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition {{ request()->routeIs('reports.*') ? 'bg-indigo-600 text-white' : '' }}">Billing Reports</a>
            </nav>
            <div class="p-4 border-t border-slate-800 text-xs text-slate-500">
                Logged in as: {{ Auth::user()->name ?? 'Admin' }}
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Header -->
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10">
                <div class="font-semibold text-gray-800 text-lg">
                    {{ $header ?? 'Dashboard' }}
                </div>
                <div class="flex items-center gap-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">Logout</button>
                    </form>
                </div>
            </header>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mx-8 mt-4 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 text-sm shadow-sm rounded-r">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mx-8 mt-4 bg-red-50 border-l-4 border-red-500 p-4 text-red-700 text-sm shadow-sm rounded-r">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Page Content -->
            <main class="flex-1 p-8 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>