<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Event Management
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Manage events, seats, registration fees and event status.
                </p>
            </div>

            <a
                href="{{ route('events.create') }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-indigo-700"
            >
                + Add Event
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Search & Filters --}}
            <form
                method="GET"
                action="{{ route('events.index') }}"
                class="bg-white p-6 rounded-lg shadow-sm mb-8"
            >
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    {{-- Search --}}
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

                    {{-- Status --}}
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
                            <option value="">All Status</option>

                            <option
                                value="draft"
                                {{ request('status') === 'draft' ? 'selected' : '' }}
                            >
                                Draft
                            </option>

                            <option
                                value="published"
                                {{ request('status') === 'published' ? 'selected' : '' }}
                            >
                                Published
                            </option>

                            <option
                                value="completed"
                                {{ request('status') === 'completed' ? 'selected' : '' }}
                            >
                                Completed
                            </option>

                            <option
                                value="cancelled"
                                {{ request('status') === 'cancelled' ? 'selected' : '' }}
                            >
                                Cancelled
                            </option>
                        </select>
                    </div>

                    {{-- Date --}}
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

                    {{-- Buttons --}}
                    <div class="flex items-end gap-2">
                        <button
                            type="submit"
                            class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700"
                        >
                            Search
                        </button>

                        <a
                            href="{{ route('events.index') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                        >
                            Reset
                        </a>
                    </div>

                </div>
            </form>

            {{-- Events Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($events as $event)

                    <div class="bg-white rounded-lg shadow-sm overflow-hidden flex flex-col">

                        <div class="p-6 flex-1">

                            {{-- Event Title --}}
                            <h3 class="text-xl font-bold text-gray-900">
                                {{ $event->title }}
                            </h3>

                            {{-- Description --}}
                            <p class="text-sm text-gray-600 mt-2">
                                {{ \Illuminate\Support\Str::limit($event->description, 120) }}
                            </p>

                            {{-- Event Date --}}
                            <div class="mt-4">
                                <p class="text-sm text-gray-500">
                                    Event Date
                                </p>

                                <p class="font-medium text-gray-900">
                                    {{ $event->event_date?->format('M d, Y h:i A') }}
                                </p>
                            </div>

                            {{-- Total Seats --}}
                            <div class="mt-3">
                                <p class="text-sm text-gray-500">
                                    Total Seats
                                </p>

                                <p class="font-semibold text-gray-900">
                                    {{ $event->total_seats }}
                                </p>
                            </div>

                            {{-- Registered Seats --}}
                            <div class="mt-3">
                                <p class="text-sm text-gray-500">
                                    Registered Seats
                                </p>

                                <p class="font-semibold text-green-600">
                                    {{ $event->registrations_sum_tickets_count ?? 0 }}
                                </p>
                            </div>

                            {{-- Available Seats --}}
                            <div class="mt-3">
                                <p class="text-sm text-gray-500">
                                    Available Seats
                                </p>

                                <p class="font-semibold text-indigo-600">
                                    {{ $event->available_seats }}
                                </p>
                            </div>

                            {{-- Fee --}}
                            <div class="mt-3">
                                <p class="text-sm text-gray-500">
                                    Registration Fee
                                </p>

                                <p class="text-lg font-bold text-indigo-600">
                                    ₹{{ number_format($event->registration_fee, 2) }}
                                </p>
                            </div>

                            {{-- Status --}}
                            <div class="mt-4">
                                <span
                                    class="px-2.5 py-1 text-xs font-semibold rounded-full
                                    @if($event->status === 'published')
                                        bg-green-100 text-green-800
                                    @elseif($event->status === 'completed')
                                        bg-blue-100 text-blue-800
                                    @elseif($event->status === 'cancelled')
                                        bg-red-100 text-red-800
                                    @else
                                        bg-yellow-100 text-yellow-800
                                    @endif"
                                >
                                    {{ ucfirst($event->status) }}
                                </span>
                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="px-6 pb-6">

                            <div class="flex items-center gap-2">

                                {{-- View --}}
                                <a
                                    href="{{ route('events.show', $event) }}"
                                    class="flex-1 text-center bg-indigo-600 text-white py-2 rounded-md text-sm hover:bg-indigo-700"
                                >
                                    View
                                </a>

                                {{-- Edit --}}
                                <a
                                    href="{{ route('events.edit', $event) }}"
                                    class="flex-1 text-center bg-yellow-500 text-white py-2 rounded-md text-sm hover:bg-yellow-600"
                                >
                                    Edit
                                </a>

                                {{-- Delete --}}
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
                                        class="w-full bg-red-600 text-white py-2 rounded-md text-sm hover:bg-red-700"
                                    >
                                        Delete
                                    </button>
                                </form>

                            </div>

                        </div>

                    </div>

                @empty

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

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $events->links() }}
            </div>

        </div>
    </div>
</x-app-layout>