<x-app-layout>
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
        <form method="GET"
              action="{{ route('events.index') }}"
              class="bg-white p-6 rounded-lg shadow-sm mb-8">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
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
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="">All Status</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>
                            Published
                        </option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>
                    </select>
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">
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
                        href="{{ route('events.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                    >
                        Reset
                    </a>

                </div>

            </div>
        </form>

        <!-- Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse($events as $event)

                <div class="bg-white rounded-lg shadow-sm overflow-hidden flex flex-col">

                    <div class="p-6 flex-1">

                        <!-- Event Title -->
                        <h3 class="text-xl font-bold text-gray-900">
                            {{ $event->title }}
                        </h3>

                        <!-- Description -->
                        <p class="text-sm text-gray-600 mt-2">
                            {{ \Illuminate\Support\Str::limit($event->description, 120) }}
                        </p>

                        <!-- Event Date -->
                        <div class="mt-4">
                            <p class="text-sm text-gray-500">
                                Event Date
                            </p>

                            <p class="font-medium text-gray-900">
                                {{ $event->event_date?->format('M d, Y h:i A') }}
                            </p>
                        </div>

                        <!-- Seats -->
                        <div class="mt-3">
                            <p class="text-sm text-gray-500">
                                Available Seats
                            </p>

                            <p class="font-semibold text-indigo-600">
                                {{ $event->available_seats }}
                                / {{ $event->total_seats }}
                            </p>
                        </div>

                        <!-- Fee -->
                        <div class="mt-3">
                            <p class="text-sm text-gray-500">
                                Registration Fee
                            </p>

                            <p class="text-lg font-bold text-indigo-600">
                                ₹{{ number_format($event->registration_fee, 2) }}
                            </p>
                        </div>

                        <!-- Status -->
                        <div class="mt-4">

                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                                {{ $event->status === 'published'
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-yellow-100 text-yellow-800' }}">

                                {{ ucfirst($event->status) }}

                            </span>

                        </div>

                    </div>

                    <!-- View Details -->
                    <div class="p-6 pt-0">

                        <a
                            href="{{ route('events.show', $event) }}"
                            class="block text-center bg-indigo-600 text-white py-2.5 rounded-md hover:bg-indigo-700"
                        >
                            View Details
                        </a>

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

        <!-- Pagination -->
        <div class="mt-8">
            {{ $events->links() }}
        </div>

    </div>
</x-app-layout>