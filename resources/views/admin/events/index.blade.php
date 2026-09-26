<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 tracking-tight leading-tight">
                    Event Management
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">
                    Manage events, seats, registration fees and event status.
                </p>
            </div>

            <a
                href="{{ route('events.create') }}"
                class="inline-flex items-center justify-center bg-[#2874B8] hover:bg-[#215d96] text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-blue-500/20 transition"
            >
                + Add Event
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="bg-emerald-50 border-2 border-emerald-200 text-emerald-800 px-6 py-4 rounded-2xl shadow-sm relative">
                    <span class="font-bold block">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Search & Filters --}}
            <form
                method="GET"
                action="{{ route('events.index') }}"
                class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100"
            >
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    {{-- Search --}}
                    <div>
                        <label for="search" class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">
                            Search
                        </label>
                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search events..."
                            class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#2874B8] focus:ring-[#2874B8] text-sm py-2.5"
                        >
                    </div>

                    {{-- Status --}}
                    <div>
                        <label for="status" class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">
                            Status
                        </label>
                        <select
                            id="status"
                            name="status"
                            class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#2874B8] focus:ring-[#2874B8] text-sm py-2.5"
                        >
                            <option value="">All Status</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    {{-- Date --}}
                    <div>
                        <label for="date" class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">
                            Event Date
                        </label>
                        <input
                            type="date"
                            id="date"
                            name="date"
                            value="{{ request('date') }}"
                            class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#2874B8] focus:ring-[#2874B8] text-sm py-2.5"
                        >
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-end gap-2">
                        <button
                            type="submit"
                            class="flex-1 bg-gray-900 hover:bg-gray-800 text-white px-4 py-2.5 rounded-xl font-bold text-sm transition shadow-sm"
                        >
                            Search
                        </button>

                        <a
                            href="{{ route('events.index') }}"
                            class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-bold text-sm transition"
                        >
                            Reset
                        </a>
                    </div>

                </div>
            </form>

            {{-- Events Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($events as $event)
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden flex flex-col transition hover:shadow-2xl">

                        <div class="p-6 flex-1 space-y-4">

                            {{-- Status Badge & Title --}}
                            <div class="flex justify-between items-start gap-2">
                                <h3 class="text-lg font-extrabold text-gray-900 tracking-tight leading-snug">
                                    {{ $event->title }}
                                </h3>
                                <span
                                    class="shrink-0 px-3 py-1 text-xs font-black uppercase tracking-wider rounded-full
                                    @if($event->status === 'published')
                                        bg-emerald-50 text-emerald-700 border border-emerald-200
                                    @elseif($event->status === 'completed')
                                        bg-blue-50 text-blue-700 border border-blue-200
                                    @elseif($event->status === 'cancelled')
                                        bg-rose-50 text-rose-700 border border-rose-200
                                    @else
                                        bg-amber-50 text-amber-700 border border-amber-200
                                    @endif"
                                >
                                    {{ ucfirst($event->status) }}
                                </span>
                            </div>

                            {{-- Description --}}
                            <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">
                                {{ $event->description }}
                            </p>

                            <div class="border-t border-gray-100 pt-4 space-y-3">
                                {{-- Event Date --}}
                                <div class="flex justify-between items-center text-xs">
                                    <span class="font-bold uppercase tracking-wider text-gray-400">Date</span>
                                    <span class="font-semibold text-gray-900">{{ $event->event_date?->format('M d, Y h:i A') }}</span>
                                </div>

                                {{-- Seat Metrics Grid --}}
                                <div class="grid grid-cols-3 gap-2 bg-gray-50 p-3 rounded-2xl text-center">
                                    <div>
                                        <span class="block text-[10px] uppercase font-bold text-gray-400">Total</span>
                                        <span class="text-sm font-black text-gray-800">{{ $event->total_seats }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-[10px] uppercase font-bold text-gray-400">Registered</span>
                                        <span class="text-sm font-black text-emerald-600">{{ $event->registrations_sum_tickets_count ?? 0 }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-[10px] uppercase font-bold text-gray-400">Available</span>
                                        <span class="text-sm font-black text-[#2874B8]">{{ $event->available_seats }}</span>
                                    </div>
                                </div>

                                {{-- Fee --}}
                                <div class="flex justify-between items-center pt-1">
                                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Fee</span>
                                    <span class="text-lg font-black text-[#2874B8]">₹{{ number_format($event->registration_fee, 2) }}</span>
                                </div>
                            </div>

                        </div>

                        {{-- Actions Bar --}}
                        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center gap-2">
                            <a
                                href="{{ route('events.show', $event) }}"
                                class="flex-1 text-center bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 py-2 rounded-xl text-xs font-bold shadow-sm transition"
                            >
                                View
                            </a>

                            <a
                                href="{{ route('events.edit', $event) }}"
                                class="flex-1 text-center bg-amber-500 hover:bg-amber-600 text-white py-2 rounded-xl text-xs font-bold shadow-sm transition"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('events.destroy', $event) }}"
                                method="POST"
                                class="flex-1"
                                onsubmit="return confirm('Are you sure you want to delete this event?');"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="w-full bg-rose-600 hover:bg-rose-700 text-white py-2 rounded-xl text-xs font-bold shadow-sm transition"
                                >
                                    Delete
                                </button>
                            </form>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl shadow-xl border border-gray-100 p-12 text-center space-y-3">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto text-gray-400 font-bold text-xl">!</div>
                        <h3 class="text-lg font-extrabold text-gray-800">
                            No events found
                        </h3>
                        <p class="text-sm text-gray-500 max-w-sm mx-auto">
                            Try changing your search terms or filter configurations.
                        </p>
                    </div>
                @endforelse

            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $events->links() }}
            </div>

        </div>
    </div>
</x-app-layout>