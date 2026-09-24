<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $event->title }}
            </h2>

            <div class="space-x-2">
                <a
                    href="{{ route('events.edit', $event->id) }}"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700"
                >
                    Edit Event
                </a>

                <a
                    href="{{ route('events.index') }}"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-300"
                >
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Event Information -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <div class="flex items-center justify-between border-b pb-4">

                    <div>
                        <h3 class="text-xl font-bold text-gray-900">
                            {{ $event->title }}
                        </h3>

                        <span class="inline-block mt-2 px-3 py-1 text-xs font-semibold rounded-full
                            {{ $event->status === 'published'
                                ? 'bg-green-100 text-green-800'
                                : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($event->status) }}
                        </span>
                    </div>

                    <div class="text-sm text-gray-500">
                        Event Date:
                        <span class="font-medium text-gray-900">
                            {{ $event->event_date->format('M d, Y h:i A') }}
                        </span>
                    </div>

                </div>

                <!-- Description -->
                <div class="mt-6">
                    <h4 class="font-semibold text-gray-900">
                        Description
                    </h4>

                    <p class="mt-2 text-gray-600 leading-relaxed">
                        {{ $event->description ?: 'No description available.' }}
                    </p>
                </div>

                <!-- Registration Window -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">

                    <div>
                        <span class="text-sm text-gray-500 block">
                            Registration Start
                        </span>

                        <span class="font-medium text-gray-800">
                            {{ $event->registration_start_date->format('M d, Y h:i A') }}
                        </span>
                    </div>

                    <div>
                        <span class="text-sm text-gray-500 block">
                            Registration End
                        </span>

                        <span class="font-medium text-gray-800">
                            {{ $event->registration_end_date->format('M d, Y h:i A') }}
                        </span>
                    </div>

                </div>

                <!-- Fees -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div class="border rounded-lg p-4">
                        <p class="text-sm text-gray-500">
                            Registration Fee
                        </p>

                        <p class="text-xl font-bold text-gray-900">
                            ₹{{ number_format($event->registration_fee, 2) }}
                        </p>
                    </div>

                    <div class="border rounded-lg p-4">
                        <p class="text-sm text-gray-500">
                            Workshop Fee
                        </p>

                        <p class="text-xl font-bold text-gray-900">
                            ₹{{ number_format($event->workshop_fee, 2) }}
                        </p>
                    </div>

                    <div class="border rounded-lg p-4">
                        <p class="text-sm text-gray-500">
                            Food Fee
                        </p>

                        <p class="text-xl font-bold text-gray-900">
                            ₹{{ number_format($event->food_fee, 2) }}
                        </p>
                    </div>

                </div>

            </div>

            <!-- Registration Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <div class="bg-white shadow-sm rounded-lg p-5">
                    <p class="text-sm text-gray-500">
                        Total Seats
                    </p>

                    <p class="text-2xl font-bold text-gray-900">
                        {{ $event->total_seats }}
                    </p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-5">
                    <p class="text-sm text-gray-500">
                        Registered Tickets
                    </p>

                    <p class="text-2xl font-bold text-indigo-600">
                        {{ $registeredTickets }}
                    </p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-5">
                    <p class="text-sm text-gray-500">
                        Available Seats
                    </p>

                    <p class="text-2xl font-bold text-green-600">
                        {{ $event->available_seats }}
                    </p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-5">
                    <p class="text-sm text-gray-500">
                        Total Revenue
                    </p>

                    <p class="text-2xl font-bold text-gray-900">
                        ₹{{ number_format($revenue, 2) }}
                    </p>
                </div>

            </div>

            <!-- Registrations -->
            <div class="bg-white shadow-sm rounded-lg p-6">

                <div class="flex justify-between items-center mb-5">

                    <div>
                        <h3 class="text-lg font-bold text-gray-900">
                            Event Registrations
                        </h3>

                        <p class="text-sm text-gray-500">
                            {{ $registeredCount }} registration(s)
                        </p>
                    </div>

                </div>

                @if($event->registrations->count())

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">

                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        ID
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Participant
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Tickets
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Amount
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Payment Status
                                    </th>
                                </tr>

                            </thead>

                            <tbody class="divide-y divide-gray-200">

                                @foreach($event->registrations as $registration)

                                    <tr>

                                        <td class="px-4 py-3">
                                            #{{ $registration->id }}
                                        </td>

                                        <td class="px-4 py-3">

                                            <div class="font-medium text-gray-900">
                                                {{ $registration->participant->name }}
                                            </div>

                                            <div class="text-sm text-gray-500">
                                                {{ $registration->participant->email }}
                                            </div>

                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $registration->tickets_count }}
                                        </td>

                                        <td class="px-4 py-3 font-medium">
                                            ₹{{ number_format($registration->final_amount, 2) }}
                                        </td>

                                        <td class="px-4 py-3">

                                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                {{ $registration->payment_status === 'paid'
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($registration->payment_status) }}
                                            </span>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="text-center py-8 text-gray-500">
                        No registrations found for this event.
                    </div>

                @endif

            </div>

        </div>
    </div>
</x-app-layout>