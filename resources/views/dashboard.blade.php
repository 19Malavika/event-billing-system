<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Success / Flash Messages -->
            @if (session('success'))
                <div
                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm"
                    role="alert"
                >
                    <span class="block sm:inline">
                        {{ session('success') }}
                    </span>
                </div>
            @endif


            <!-- Metric Cards -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

                <!-- Total Events -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-indigo-500">
                    <div class="text-sm font-medium text-gray-500 truncate">
                        Total Events
                    </div>

                    <div class="mt-1 text-3xl font-semibold text-gray-900">
                        {{ $totalEvents }}
                    </div>
                </div>


                <!-- Upcoming Events -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-sm font-medium text-gray-500 truncate">
                        Upcoming Events
                    </div>

                    <div class="mt-1 text-3xl font-semibold text-gray-900">
                        {{ $upcomingEventsCount }}
                    </div>
                </div>


                <!-- Total Participants -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-sm font-medium text-gray-500 truncate">
                        Total Participants
                    </div>

                    <div class="mt-1 text-3xl font-semibold text-gray-900">
                        {{ $totalParticipants }}
                    </div>
                </div>


                <!-- Total Registrations -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-sm font-medium text-gray-500 truncate">
                        Total Registrations
                    </div>

                    <div class="mt-1 text-3xl font-semibold text-gray-900">
                        {{ $totalRegistrations }}
                    </div>
                </div>


                <!-- Total Revenue -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-sm font-medium text-gray-500 truncate">
                        Total Revenue (Paid)
                    </div>

                    <div class="mt-1 text-3xl font-semibold text-gray-900">
                        ₹{{ number_format($totalRevenue, 2) }}
                    </div>
                </div>


                <!-- Available Seats -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-teal-500">
                    <div class="text-sm font-medium text-gray-500 truncate">
                        Available Seats Pool
                    </div>

                    <div class="mt-1 text-3xl font-semibold text-gray-900">
                        {{ $availableSeats }}
                    </div>
                </div>

            </div>


            <!-- Upcoming Events -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-4">

                        <h3 class="text-lg font-medium text-gray-900">
                            Next 5 Upcoming Events
                        </h3>

                        <a
                            href="{{ route('events.index') }}"
                            class="text-sm text-indigo-600 hover:text-indigo-900 font-semibold"
                        >
                            View All Events →
                        </a>

                    </div>


                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead>

                                <tr>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Event Name
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Event Date
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Seats Left / Total
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fee
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="bg-white divide-y divide-gray-200">

                                @forelse($upcomingEvents as $event)

                                    <tr>

                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            {{ $event->title }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $event->event_date->format('M d, Y H:i') }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">

                                            <span class="font-semibold text-indigo-600">
                                                {{ $event->available_seats }}
                                            </span>

                                            /
                                            {{ $event->total_seats }}

                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            ₹{{ number_format($event->registration_fee, 2) }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ ucfirst($event->status) }}
                                            </span>

                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                                            <a
                                                href="{{ route('events.show', $event) }}"
                                                class="text-indigo-600 hover:text-indigo-900"
                                            >
                                                Details
                                            </a>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="6"
                                            class="px-6 py-4 text-center text-sm text-gray-500"
                                        >
                                            No upcoming events scheduled at the moment.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>


            <!-- Recent Registrations -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-4">

                        <h3 class="text-lg font-medium text-gray-900">
                            Recent Registrations
                        </h3>

                        <a
                            href="{{ route('registrations.index') }}"
                            class="text-sm text-indigo-600 hover:text-indigo-900 font-semibold"
                        >
                            View All Registrations →
                        </a>

                    </div>


                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead>

                                <tr>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Registration ID
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Participant
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Event
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Tickets
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Amount
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Payment Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="bg-white divide-y divide-gray-200">

                                @forelse($recentRegistrations as $registration)

                                    <tr>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            #{{ $registration->id }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $registration->participant->name }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $registration->event->title }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $registration->tickets_count }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            ₹{{ number_format($registration->final_amount, 2) }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $registration->payment_status === 'paid'
                                                    ? 'bg-green-100 text-green-800'
                                                    : ($registration->payment_status === 'failed'
                                                        ? 'bg-red-100 text-red-800'
                                                        : 'bg-yellow-100 text-yellow-800') }}"
                                            >
                                                {{ ucfirst($registration->payment_status) }}
                                            </span>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="6"
                                            class="px-6 py-4 text-center text-sm text-gray-500"
                                        >
                                            No registrations yet.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>


            <!-- Registration Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <h3 class="text-lg font-medium text-gray-900 mb-6">
                        Registration Summary
                    </h3>


                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                        <!-- Paid -->
                        <div class="bg-green-50 rounded-lg p-5">

                            <p class="text-sm text-green-700">
                                Paid
                            </p>

                            <p class="text-2xl font-bold text-green-800">
                                {{ $registrationSummary['paid'] }}
                            </p>

                        </div>


                        <!-- Pending -->
                        <div class="bg-yellow-50 rounded-lg p-5">

                            <p class="text-sm text-yellow-700">
                                Pending
                            </p>

                            <p class="text-2xl font-bold text-yellow-800">
                                {{ $registrationSummary['pending'] }}
                            </p>

                        </div>


                        <!-- Failed -->
                        <div class="bg-red-50 rounded-lg p-5">

                            <p class="text-sm text-red-700">
                                Failed
                            </p>

                            <p class="text-2xl font-bold text-red-800">
                                {{ $registrationSummary['failed'] }}
                            </p>

                        </div>


                        <!-- Refunded -->
                        <div class="bg-gray-50 rounded-lg p-5">

                            <p class="text-sm text-gray-700">
                                Refunded
                            </p>

                            <p class="text-2xl font-bold text-gray-800">
                                {{ $registrationSummary['refunded'] }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Revenue Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <h3 class="text-lg font-medium text-gray-900 mb-6">
                        Revenue Summary
                    </h3>


                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <!-- Paid Revenue -->
                        <div class="bg-green-50 rounded-lg p-5">

                            <p class="text-sm text-green-700">
                                Paid Revenue
                            </p>

                            <p class="text-2xl font-bold text-green-800">
                                ₹{{ number_format($revenueSummary['paid'], 2) }}
                            </p>

                        </div>


                        <!-- Pending Revenue -->
                        <div class="bg-yellow-50 rounded-lg p-5">

                            <p class="text-sm text-yellow-700">
                                Pending Revenue
                            </p>

                            <p class="text-2xl font-bold text-yellow-800">
                                ₹{{ number_format($revenueSummary['pending'], 2) }}
                            </p>

                        </div>


                        <!-- Refunded Revenue -->
                        <div class="bg-gray-50 rounded-lg p-5">

                            <p class="text-sm text-gray-700">
                                Refunded Revenue
                            </p>

                            <p class="text-2xl font-bold text-gray-800">
                                ₹{{ number_format($revenueSummary['refunded'], 2) }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>