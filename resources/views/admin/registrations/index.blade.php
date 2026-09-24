<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Event Registrations & Billing') }}
            </h2>

            <a href="{{ route('registrations.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                + New Registration
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm">
                    <span class="block sm:inline">
                        {{ session('success') }}
                    </span>
                </div>
            @endif

            {{-- Search & Filters --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">

                <form method="GET"
                      action="{{ route('registrations.index') }}"
                      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">

                    {{-- Search --}}
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Search
                        </label>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Participant name, email or event..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>

                    {{-- Event Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Event
                        </label>

                        <select
                            name="event_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">All Events</option>

                            @foreach ($events as $event)
                                <option
                                    value="{{ $event->id }}"
                                    {{ request('event_id') == $event->id ? 'selected' : '' }}
                                >
                                    {{ $event->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Payment Status --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Payment
                        </label>

                        <select
                            name="payment_status"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">All Statuses</option>

                            <option value="paid"
                                {{ request('payment_status') === 'paid' ? 'selected' : '' }}>
                                Paid
                            </option>

                            <option value="pending"
                                {{ request('payment_status') === 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="failed"
                                {{ request('payment_status') === 'failed' ? 'selected' : '' }}>
                                Failed
                            </option>

                            <option value="refunded"
                                {{ request('payment_status') === 'refunded' ? 'selected' : '' }}>
                                Refunded
                            </option>
                        </select>
                    </div>

                    {{-- Date --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Registration Date
                        </label>

                        <input
                            type="date"
                            name="date"
                            value="{{ request('date') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>

                    {{-- Buttons --}}
                    <div class="md:col-span-2 lg:col-span-5 flex gap-3">

                        <button
                            type="submit"
                            class="bg-gray-800 text-white px-5 py-2 rounded-md text-sm hover:bg-gray-700"
                        >
                            Apply Filters
                        </button>

                        <a
                            href="{{ route('registrations.index') }}"
                            class="bg-gray-200 text-gray-700 px-5 py-2 rounded-md text-sm hover:bg-gray-300"
                        >
                            Reset
                        </a>

                    </div>

                </form>
            </div>

            {{-- Registrations Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead>
                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Participant
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Event
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tickets
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Payment
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Registration Date
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>

                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">

                            @forelse ($registrations as $registration)

                                <tr>

                                    {{-- ID --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        #{{ $registration->id }}
                                    </td>

                                    {{-- Participant --}}
                                    <td class="px-6 py-4 whitespace-nowrap">

                                        <div class="font-medium text-gray-900">
                                            {{ $registration->participant->name ?? 'N/A' }}
                                        </div>

                                        <div class="text-xs text-gray-500">
                                            {{ $registration->participant->email ?? '' }}
                                        </div>

                                    </td>

                                    {{-- Event --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $registration->event->title ?? 'N/A' }}
                                    </td>

                                    {{-- Tickets --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-semibold">
                                        {{ $registration->tickets_count }}
                                    </td>

                                    {{-- Amount --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">
                                        ₹{{ number_format($registration->final_amount, 2) }}
                                    </td>

                                    {{-- Payment --}}
                                    <td class="px-6 py-4 whitespace-nowrap">

                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if ($registration->payment_status === 'paid')
                                                bg-green-100 text-green-800
                                            @elseif ($registration->payment_status === 'pending')
                                                bg-yellow-100 text-yellow-800
                                            @elseif ($registration->payment_status === 'refunded')
                                                bg-blue-100 text-blue-800
                                            @else
                                                bg-red-100 text-red-800
                                            @endif"
                                        >
                                            {{ ucfirst($registration->payment_status) }}
                                        </span>

                                    </td>

                                    {{-- Registration Date --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $registration->registration_date?->format('d M Y') }}
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">

                                        <a
                                            href="{{ route('registrations.show', $registration) }}"
                                            class="text-indigo-600 hover:text-indigo-900"
                                        >
                                            View
                                        </a>

                                        <a
                                            href="{{ route('registrations.edit', $registration) }}"
                                            class="text-yellow-600 hover:text-yellow-900"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('registrations.destroy', $registration) }}"
                                            method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this registration? This will restore the allocated seats.');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="text-red-600 hover:text-red-900"
                                            >
                                                Delete
                                            </button>
                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td
                                        colspan="8"
                                        class="px-6 py-8 text-center text-sm text-gray-500"
                                    >
                                        No registrations found.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $registrations->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>