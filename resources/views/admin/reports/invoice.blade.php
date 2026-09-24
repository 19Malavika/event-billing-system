<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">

                <!-- Header -->
                <div class="p-6 border-b border-gray-200 flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            Tax Invoice / Receipt
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Registration ID: #{{ $registration->id }}
                        </p>
                    </div>

                    <span
                        class="px-3 py-1 rounded-full text-sm font-semibold uppercase
                        @if($registration->payment_status === 'paid')
                            bg-green-100 text-green-800
                        @elseif($registration->payment_status === 'pending')
                            bg-yellow-100 text-yellow-800
                        @elseif($registration->payment_status === 'failed')
                            bg-red-100 text-red-800
                        @else
                            bg-gray-100 text-gray-800
                        @endif"
                    >
                        {{ $registration->payment_status }}
                    </span>
                </div>

                <!-- Participant & Event Details -->
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Participant -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">
                            Participant Details
                        </h3>

                        <p class="font-semibold text-gray-900">
                            {{ $registration->participant->name }}
                        </p>

                        <p class="text-gray-600">
                            {{ $registration->participant->email }}
                        </p>

                        <p class="text-gray-600">
                            {{ $registration->participant->phone ?? 'N/A' }}
                        </p>

                        <p class="text-gray-600">
                            {{ $registration->participant->course_department }}
                        </p>
                    </div>

                    <!-- Event -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">
                            Event Details
                        </h3>

                        <p class="font-semibold text-gray-900">
                            {{ $registration->event->title }}
                        </p>

                        <p class="text-gray-600">
                            Date:
                            {{ $registration->event->event_date->format('M d, Y h:i A') }}
                        </p>

                        <p class="text-gray-600">
                            Tickets:
                            {{ $registration->tickets_count }}
                        </p>

                        <p class="text-gray-600">
                            Registration Date:
                            {{ $registration->registration_date->format('M d, Y h:i A') }}
                        </p>
                    </div>
                </div>

                <!-- Billing Table -->
                <div class="px-6 pb-6 overflow-x-auto">

                    <table class="w-full border-collapse">

                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="p-3 text-left text-sm font-semibold text-gray-700">
                                    Description
                                </th>

                                <th class="p-3 text-right text-sm font-semibold text-gray-700">
                                    Amount
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            <!-- Event Fee -->
                            <tr>
                                <td class="p-3">
                                    Event Fee
                                    <span class="text-sm text-gray-500">
                                        ({{ $registration->tickets_count }} tickets ×
                                        ₹{{ number_format($registration->event->registration_fee, 2) }})
                                    </span>
                                </td>

                                <td class="p-3 text-right">
                                    ₹{{ number_format(
                                        $registration->event->registration_fee * $registration->tickets_count,
                                        2
                                    ) }}
                                </td>
                            </tr>

                            <!-- Workshop Fee -->
                            <tr>
                                <td class="p-3">
                                    Workshop Fee
                                </td>

                                <td class="p-3 text-right">
                                    ₹{{ number_format(
                                        $registration->additional_workshop
                                            ? $registration->event->workshop_fee * $registration->tickets_count
                                            : 0,
                                        2
                                    ) }}
                                </td>
                            </tr>

                            <!-- Food Fee -->
                            <tr>
                                <td class="p-3">
                                    Food Fee
                                    @if($registration->food_preference)
                                        <span class="text-sm text-gray-500">
                                            ({{ $registration->food_preference }})
                                        </span>
                                    @endif
                                </td>

                                <td class="p-3 text-right">
                                    ₹{{ number_format(
                                        $registration->food_preference
                                            ? $registration->event->food_fee * $registration->tickets_count
                                            : 0,
                                        2
                                    ) }}
                                </td>
                            </tr>

                            <!-- Subtotal -->
                            <tr>
                                <td class="p-3 font-semibold">
                                    Subtotal
                                </td>

                                <td class="p-3 text-right font-semibold">
                                    ₹{{ number_format($registration->subtotal, 2) }}
                                </td>
                            </tr>

                            <!-- Discount -->
                            <tr>
                                <td class="p-3">
                                    Discount
                                    ({{ number_format($registration->discount_percentage, 2) }}%)
                                </td>

                                <td class="p-3 text-right text-red-600">
                                    -₹{{ number_format($registration->discount_amount, 2) }}
                                </td>
                            </tr>

                            <!-- Final Amount -->
                            <tr class="bg-gray-50">
                                <td class="p-3 text-lg font-bold">
                                    Final Amount
                                </td>

                                <td class="p-3 text-right text-lg font-bold text-indigo-600">
                                    ₹{{ number_format($registration->final_amount, 2) }}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <!-- Payment Status -->
                <div class="px-6 pb-6">
                    <div class="border rounded-lg p-4 bg-gray-50">

                        <div class="flex justify-between">
                            <span class="font-semibold text-gray-700">
                                Payment Status
                            </span>

                            <span class="font-bold uppercase">
                                {{ $registration->payment_status }}
                            </span>
                        </div>

                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 pb-6 flex justify-end gap-3">

                    <button
                        onclick="window.print()"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-indigo-700"
                    >
                        Print Invoice
                    </button>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>