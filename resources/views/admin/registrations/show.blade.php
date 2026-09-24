<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">

            <h2 class="font-semibold text-xl text-gray-800">
                Registration #{{ $registration->id }}
            </h2>

            <a
                href="{{ route('reports.invoice', $registration) }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm"
            >
                View Invoice
            </a>

        </div>
    </x-slot>

    <div class="py-12">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white shadow-sm rounded-lg p-6">

                    <h3 class="text-lg font-bold mb-4">
                        Participant Information
                    </h3>

                    <div class="space-y-3">

                        <p>
                            <span class="text-gray-500">Name:</span>
                            <strong>{{ $registration->participant->name }}</strong>
                        </p>

                        <p>
                            <span class="text-gray-500">Email:</span>
                            {{ $registration->participant->email }}
                        </p>

                        <p>
                            <span class="text-gray-500">Phone:</span>
                            {{ $registration->participant->phone ?? 'N/A' }}
                        </p>

                        <p>
                            <span class="text-gray-500">Course:</span>
                            {{ $registration->participant->course_department }}
                        </p>

                    </div>

                </div>

                <div class="bg-white shadow-sm rounded-lg p-6">

                    <h3 class="text-lg font-bold mb-4">
                        Event Information
                    </h3>

                    <div class="space-y-3">

                        <p>
                            <span class="text-gray-500">Event:</span>
                            <strong>{{ $registration->event->title }}</strong>
                        </p>

                        <p>
                            <span class="text-gray-500">Date:</span>
                            {{ $registration->event->event_date->format('M d, Y h:i A') }}
                        </p>

                        <p>
                            <span class="text-gray-500">Tickets:</span>
                            {{ $registration->tickets_count }}
                        </p>

                        <p>
                            <span class="text-gray-500">Registration Date:</span>
                            {{ $registration->registration_date->format('M d, Y h:i A') }}
                        </p>

                    </div>

                </div>

            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">

                <h3 class="text-lg font-bold mb-5">
                    Billing Details
                </h3>

                <div class="space-y-3">

                    <div class="flex justify-between">
                        <span>Event Fee</span>
                        <span>
                            ₹{{ number_format($registration->event->registration_fee * $registration->tickets_count, 2) }}
                        </span>
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

                    <div class="border-t pt-3 flex justify-between">
                        <span>Subtotal</span>
                        <span>
                            ₹{{ number_format($registration->subtotal, 2) }}
                        </span>
                    </div>

                    <div class="flex justify-between text-green-600">
                        <span>
                            Discount ({{ $registration->discount_percentage }}%)
                        </span>

                        <span>
                            - ₹{{ number_format($registration->discount_amount, 2) }}
                        </span>
                    </div>

                    <div class="border-t pt-3 flex justify-between text-xl font-bold">

                        <span>
                            Final Amount
                        </span>

                        <span class="text-indigo-600">
                            ₹{{ number_format($registration->final_amount, 2) }}
                        </span>

                    </div>

                    <div class="pt-3">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            {{ $registration->payment_status === 'paid'
                                ? 'bg-green-100 text-green-800'
                                : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($registration->payment_status) }}
                        </span>
                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>