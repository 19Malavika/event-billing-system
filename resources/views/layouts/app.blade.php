<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Event Registration System') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800">
    <div class="min-h-screen flex">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-slate-300 hidden md:flex flex-col shadow-xl border-r border-slate-800">
            <!-- Brand Logo Header -->
            <div class="h-16 flex items-center px-6 bg-slate-950 text-white font-black text-lg tracking-wider border-b border-slate-800/80">
                <span class="text-rose-500 mr-2">■</span> EventHub <span class="text-xs ml-2 px-2 py-0.5 bg-rose-600/30 text-rose-300 rounded-full font-semibold">Admin</span>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-3 py-6 space-y-1.5 text-sm font-medium">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition group {{ request()->routeIs('dashboard') ? 'bg-rose-600 text-white shadow-lg shadow-rose-900/20 font-semibold' : 'hover:bg-slate-800/60 hover:text-white text-slate-400' }}">
                    Dashboard
                </a>
                <a href="{{ route('events.index') }}" class="flex items-center px-4 py-3 rounded-xl transition group {{ request()->routeIs('events.*') ? 'bg-rose-600 text-white shadow-lg shadow-rose-900/20 font-semibold' : 'hover:bg-slate-800/60 hover:text-white text-slate-400' }}">
                    Events Manager
                </a>
                <a href="{{ route('participants.index') }}" class="flex items-center px-4 py-3 rounded-xl transition group {{ request()->routeIs('participants.*') ? 'bg-rose-600 text-white shadow-lg shadow-rose-900/20 font-semibold' : 'hover:bg-slate-800/60 hover:text-white text-slate-400' }}">
                    Participants
                </a>
                <a href="{{ route('registrations.index') }}" class="flex items-center px-4 py-3 rounded-xl transition group {{ request()->routeIs('registrations.*') ? 'bg-rose-600 text-white shadow-lg shadow-rose-900/20 font-semibold' : 'hover:bg-slate-800/60 hover:text-white text-slate-400' }}">
                    Registrations
                </a>
                <a href="{{ route('reports.revenue') }}" class="flex items-center px-4 py-3 rounded-xl transition group {{ request()->routeIs('reports.*') ? 'bg-rose-600 text-white shadow-lg shadow-rose-900/20 font-semibold' : 'hover:bg-slate-800/60 hover:text-white text-slate-400' }}">
                    Billing Reports
                </a>
            </nav>

            <!-- User Info Footer -->
            <div class="p-4 mx-3 mb-4 rounded-xl bg-slate-950/50 border border-slate-800/80 flex items-center justify-between text-xs">
                <div>
                    <p class="text-slate-400 font-medium">Logged in as</p>
                    <p class="text-white font-bold truncate max-w-[120px]">{{ Auth::user()->name ?? 'Administrator' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-400 transition rounded-lg hover:bg-slate-900" title="Logout">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Header -->
            <header class="h-16 bg-white border-b border-slate-200/80 shadow-sm flex items-center justify-between px-8 z-10">
                <div class="font-extrabold text-slate-800 text-xl tracking-tight">
                    {{ $header ?? 'Dashboard' }}
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs font-semibold px-3 py-1 bg-slate-100 text-slate-600 rounded-full border border-slate-200">
                        Live System
                    </span>
                </div>
            </header>

            <!-- Flash Messages -->
            <div class="px-8 pt-6">
                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm shadow-sm flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl text-sm shadow-sm flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <!-- Page Content -->
            <main class="flex-1 p-8 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>