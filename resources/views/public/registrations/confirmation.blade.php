<x-app-layout>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4">

            <div class="bg-white shadow-sm rounded-lg p-8">

                <div class="text-center">

                    <div class="text-green-600 text-4xl mb-4">
                        ✓
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900">
                        Registration Successful!
                    </h1>

                    <p class="mt-2 text-gray-600">
                        Your registration has been successfully created.
                    </p>

                </div>

                <div class="mt-8 bg-gray-50 rounded-lg p-6 space-y-3">

                    <div class="flex justify-between">
                        <span class="text-gray-500">Registration ID</span>
                        <span class="font-semibold">
                            #{{ $registration->id }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Participant</span>
                        <span class="font-semibold">
                            {{ $registration->participant->name }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Event</span>
                        <span class="font-semibold">
                            {{ $registration->event->title }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Event Date</span>
                        <span class="font-semibold">
                            {{ $registration->event->event_date->format('M d, Y h:i A') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Tickets</span>
                        <span class="font-semibold">
                            {{ $registration->tickets_count }}
                        </span>
                    </div>

                    <div class="border-t pt-3 flex justify-between">
                        <span class="font-semibold">
                            Final Amount
                        </span>

                        <span class="font-bold text-indigo-600">
                            ₹{{ number_format($registration->final_amount, 2) }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">
                            Payment Status
                        </span>

                        <span class="font-semibold uppercase">
                            {{ $registration->payment_status }}
                        </span>
                    </div>

                </div>

                <div class="mt-6 flex flex-col sm:flex-row gap-3">

                    <a
                        href="{{ route('registrations.ticket', $registration) }}"
                        class="flex-1 text-center bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold"
                    >
                        View Ticket
                    </a>

                    <button
                        onclick="window.print()"
                        class="flex-1 bg-gray-800 text-white px-6 py-3 rounded-lg font-semibold"
                    >
                        Print
                    </button>

                    <a
                        href="{{ route('home') }}"
                        class="flex-1 text-center bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold"
                    >
                        Home
                    </a>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>