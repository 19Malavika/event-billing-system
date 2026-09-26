<x-public-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto px-4">

            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">

                <!-- Success Header -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-emerald-50 border border-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                        <span class="text-emerald-600 text-2xl font-bold">✓</span>
                    </div>

                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        Registration Successful!
                    </h1>

                    <p class="mt-2 text-sm text-gray-500">
                        Your registration has been successfully created.
                    </p>
                </div>

                <!-- Registration Details Card -->
                <div class="mt-8 bg-gray-50/70 rounded-2xl p-6 space-y-3.5 border border-gray-100">

                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 font-medium">Registration ID</span>
                        <span class="font-bold text-gray-900">
                            #{{ $registration->id }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 font-medium">Participant</span>
                        <span class="font-bold text-gray-900">
                            {{ $registration->participant->name }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 font-medium">Event</span>
                        <span class="font-bold text-indigo-950 text-right">
                            {{ $registration->event->title }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 font-medium">Event Date</span>
                        <span class="font-semibold text-gray-800">
                            {{ $registration->event->event_date->format('M d, Y h:i A') }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 font-medium">Tickets</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-blue-50 text-[#2874B8] border border-blue-200">
                            {{ $registration->tickets_count }} Seats
                        </span>
                    </div>

                    <div class="border-t border-gray-200 pt-3.5 flex justify-between items-center">
                        <span class="font-bold text-gray-900">
                            Final Amount
                        </span>

                        <span class="font-black text-indigo-600 text-xl">
                            ₹{{ number_format($registration->final_amount, 2) }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center text-sm pt-1">
                        <span class="text-gray-500 font-medium">
                            Payment Status
                        </span>

                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-extrabold bg-emerald-100 text-emerald-800 uppercase tracking-wide">
                            {{ $registration->payment_status }}
                        </span>
                    </div>

                </div>

                <!-- Action Button Stack -->
                <div class="mt-8 flex flex-col sm:flex-row gap-3">

                    <a
                        href="{{ route('registrations.ticket', $registration) }}"
                        class="flex-1 text-center bg-[#2874B8] hover:bg-[#215d96] text-white px-6 py-3.5 rounded-xl font-bold shadow-lg shadow-blue-500/20 transition text-sm"
                    >
                        View Ticket
                    </a>

                    <button
                        onclick="window.print()"
                        class="flex-1 bg-gray-900 hover:bg-gray-800 text-white px-6 py-3.5 rounded-xl font-bold shadow-lg shadow-gray-900/10 transition text-sm"
                    >
                        Print Summary
                    </button>

                    <a
                        href="{{ route('home') }}"
                        class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3.5 rounded-xl font-bold transition text-sm"
                    >
                        Home
                    </a>

                </div>

            </div>

        </div>
    </div>
</x-public-layout>