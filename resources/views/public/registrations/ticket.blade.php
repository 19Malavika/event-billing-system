<x-public-layout>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4">

            <div class="bg-white shadow-lg rounded-lg overflow-hidden">

                <div class="bg-indigo-700 text-white p-6 text-center">

                    <h1 class="text-3xl font-bold">
                        Event Ticket
                    </h1>

                    <p class="mt-2 text-indigo-100">
                        Registration #{{ $registration->id }}
                    </p>

                </div>

                <div class="p-8 space-y-6">

                    <div class="text-center border-b pb-6">

                        <h2 class="text-2xl font-bold text-gray-900">
                            {{ $registration->event->title }}
                        </h2>

                        <p class="mt-2 text-gray-500">
                            {{ $registration->event->event_date->format('M d, Y h:i A') }}
                        </p>

                    </div>

                    <div class="grid grid-cols-2 gap-5">

                        <div>
                            <p class="text-xs text-gray-500 uppercase">
                                Participant
                            </p>

                            <p class="font-semibold">
                                {{ $registration->participant->name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 uppercase">
                                Email
                            </p>

                            <p class="font-semibold break-all">
                                {{ $registration->participant->email }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 uppercase">
                                Tickets
                            </p>

                            <p class="font-semibold">
                                {{ $registration->tickets_count }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 uppercase">
                                Payment
                            </p>

                            <p class="font-semibold uppercase">
                                {{ $registration->payment_status }}
                            </p>
                        </div>

                    </div>

                   <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">

    <!-- Scannable QR Code -->
    <div class="mb-4 flex justify-center">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data={{ $registration->ticket_code }}" 
             alt="Ticket QR Code" 
             class="w-32 h-32 object-contain bg-white p-2 rounded shadow-sm">
    </div>

    <p class="text-sm text-gray-500">
        Unique Ticket Code
    </p>

    <p class="mt-2 text-2xl font-mono font-bold tracking-widest">
        {{ $registration->ticket_code }}
    </p>

</div>

                    <div class="bg-gray-50 rounded-lg p-5 flex justify-between">

                        <span class="font-semibold">
                            Final Amount
                        </span>

                        <span class="font-bold text-indigo-600 text-xl">
                            ₹{{ number_format($registration->final_amount, 2) }}
                        </span>

                    </div>

                    <button
                        onclick="window.print()"
                        class="w-full bg-gray-900 text-white px-6 py-3 rounded-lg font-semibold"
                    >
                        Print Ticket
                    </button>

                </div>

            </div>

        </div>
    </div>

</x-public-layout>