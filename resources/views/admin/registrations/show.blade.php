<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-100">
                Registration #{{ $registration->id }}
            </h2>

            <a href="{{ route('reports.invoice', $registration) }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700 transition">
                View Invoice
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-900 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Info Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Participant Info --}}
                <div class="bg-slate-800 border border-slate-700 shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-100">
                        Participant Information
                    </h3>

                    <div class="space-y-3 text-gray-200">
                        <p>
                            <span class="text-gray-400">Name:</span>
                            <strong class="text-gray-100">{{ $registration->participant->name }}</strong>
                        </p>
                        <p>
                            <span class="text-gray-400">Email:</span>
                            {{ $registration->participant->email }}
                        </p>
                        <p>
                            <span class="text-gray-400">Phone:</span>
                            {{ $registration->participant->phone ?? 'N/A' }}
                        </p>
                        <p>
                            <span class="text-gray-400">Course:</span>
                            {{ $registration->participant->course_department }}
                        </p>
                    </div>
                </div>

                {{-- Event Info --}}
                <div class="bg-slate-800 border border-slate-700 shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-100">
                        Event Information
                    </h3>

                    <div class="space-y-3 text-gray-200">
                        <p>
                            <span class="text-gray-400">Event:</span>
                            <strong class="text-gray-100">{{ $registration->event->title }}</strong>
                        </p>
                        <p>
                            <span class="text-gray-400">Date:</span>
                            {{ $registration->event->event_date->format('M d, Y h:i A') }}
                        </p>
                        <p>
                            <span class="text-gray-400">Tickets:</span>
                            {{ $registration->tickets_count }}
                        </p>
                        <p>
                            <span class="text-gray-400">Registration Date:</span>
                            {{ $registration->registration_date->format('M d, Y h:i A') }}
                        </p>
                    </div>
                </div>

            </div>

            {{-- Billing Details --}}
            <div class="bg-slate-800 border border-slate-700 shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-bold mb-5 text-gray-100">
                    Billing Details
                </h3>

                <div class="space-y-3 text-gray-200">

                    <div class="flex justify-between">
                        <span>Event Fee</span>
                        <span>₹{{ number_format($registration->event->registration_fee * $registration->tickets_count, 2) }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Workshop Fee</span>
                        <span>
                            ₹{{ number_format(
                                $registration->additional_workshop
                                    ? $registration->event->workshop_fee * $registration->tickets_count
                                    : 0,
                                2
                            ) }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span>Food Fee</span>
                        <span>
                            ₹{{ number_format(
                                $registration->food_preference
                                    ? $registration->event->food_fee * $registration->tickets_count
                                    : 0,
                                2
                            ) }}
                        </span>
                    </div>

                    <div class="border-t border-slate-700 pt-3 flex justify-between font-medium text-gray-100">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($registration->subtotal, 2) }}</span>
                    </div>

                    <div class="flex justify-between text-green-400">
                        <span>Discount ({{ $registration->discount_percentage }}%)</span>
                        <span>- ₹{{ number_format($registration->discount_amount, 2) }}</span>
                    </div>

                    <div class="border-t border-slate-700 pt-3 flex justify-between text-xl font-bold">
                        <span class="text-gray-100">Final Amount</span>
                        <span class="text-indigo-400">
                            ₹{{ number_format($registration->final_amount, 2) }}
                        </span>
                    </div>

                    <div class="pt-3">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold border
                            {{ $registration->payment_status === 'paid'
                                ? 'bg-green-900/50 text-green-300 border-green-700'
                                : 'bg-yellow-900/50 text-yellow-300 border-yellow-700' }}">
                            {{ ucfirst($registration->payment_status) }}
                        </span>
                    </div>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>