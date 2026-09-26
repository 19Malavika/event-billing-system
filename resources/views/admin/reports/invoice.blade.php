<x-app-layout>
    <div class="py-12 bg-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-slate-800 border border-slate-700 shadow-lg sm:rounded-lg overflow-hidden
                        print:bg-white print:border-0 print:shadow-none">

                <!-- Header -->
                <div class="p-6 border-b border-slate-700 flex justify-between items-start
                            print:border-gray-200">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-100 print:text-gray-900">
                            Tax Invoice / Receipt
                        </h2>

                        <p class="text-sm text-gray-400 mt-1 print:text-gray-500">
                            Registration ID: #{{ $registration->id }}
                        </p>
                    </div>

                    <span class="px-3 py-1 rounded-full text-sm font-semibold uppercase border
                        @if($registration->payment_status === 'paid')
                            bg-green-900/50 text-green-300 border-green-700
                            print:bg-green-100 print:text-green-800 print:border-green-400
                        @elseif($registration->payment_status === 'pending')
                            bg-yellow-900/50 text-yellow-300 border-yellow-700
                            print:bg-yellow-100 print:text-yellow-800 print:border-yellow-400
                        @elseif($registration->payment_status === 'failed')
                            bg-red-900/50 text-red-300 border-red-700
                            print:bg-red-100 print:text-red-800 print:border-red-400
                        @else
                            bg-slate-700 text-gray-300 border-slate-600
                            print:bg-gray-100 print:text-gray-800 print:border-gray-400
                        @endif">
                        {{ $registration->payment_status }}
                    </span>
                </div>

                <!-- Participant & Event Details -->
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Participant -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-400 uppercase mb-2 print:text-gray-500">
                            Participant Details
                        </h3>
                        <p class="font-semibold text-gray-100 print:text-gray-900">
                            {{ $registration->participant->name }}
                        </p>
                        <p class="text-gray-300 print:text-gray-600">
                            {{ $registration->participant->email }}
                        </p>
                        <p class="text-gray-300 print:text-gray-600">
                            {{ $registration->participant->phone ?? 'N/A' }}
                        </p>
                        <p class="text-gray-300 print:text-gray-600">
                            {{ $registration->participant->course_department }}
                        </p>
                    </div>

                    <!-- Event -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-400 uppercase mb-2 print:text-gray-500">
                            Event Details
                        </h3>
                        <p class="font-semibold text-gray-100 print:text-gray-900">
                            {{ $registration->event->title }}
                        </p>
                        <p class="text-gray-300 print:text-gray-600">
                            Date: {{ $registration->event->event_date->format('M d, Y h:i A') }}
                        </p>
                        <p class="text-gray-300 print:text-gray-600">
                            Tickets: {{ $registration->tickets_count }}
                        </p>
                        <p class="text-gray-300 print:text-gray-600">
                            Registration Date: {{ $registration->registration_date->format('M d, Y h:i A') }}
                        </p>
                    </div>
                </div>

                <!-- Billing Table -->
                <div class="px-6 pb-6 overflow-x-auto">
                    <table class="w-full border-collapse">

                        <thead>
                            <tr class="border-b border-slate-700 bg-slate-900
                                       print:bg-gray-50 print:border-gray-200">
                                <th class="p-3 text-left text-sm font-semibold text-gray-300 print:text-gray-700">
                                    Description
                                </th>
                                <th class="p-3 text-right text-sm font-semibold text-gray-300 print:text-gray-700">
                                    Amount
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-700 print:divide-gray-200">

                            <!-- Event Fee -->
                            <tr>
                                <td class="p-3 text-gray-200 print:text-gray-900">
                                    Event Fee
                                    <span class="text-sm text-gray-400 print:text-gray-500">
                                        ({{ $registration->tickets_count }} tickets ×
                                        ₹{{ number_format($registration->event->registration_fee, 2) }})
                                    </span>
                                </td>
                                <td class="p-3 text-right text-gray-200 print:text-gray-900">
                                    ₹{{ number_format(
                                        $registration->event->registration_fee * $registration->tickets_count,
                                        2
                                    ) }}
                                </td>
                            </tr>

                            <!-- Workshop Fee -->
                            <tr>
                                <td class="p-3 text-gray-200 print:text-gray-900">Workshop Fee</td>
                                <td class="p-3 text-right text-gray-200 print:text-gray-900">
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
                                <td class="p-3 text-gray-200 print:text-gray-900">
                                    Food Fee
                                    @if($registration->food_preference)
                                        <span class="text-sm text-gray-400 print:text-gray-500">
                                            ({{ $registration->food_preference }})
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3 text-right text-gray-200 print:text-gray-900">
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
                                <td class="p-3 font-semibold text-gray-100 print:text-gray-900">Subtotal</td>
                                <td class="p-3 text-right font-semibold text-gray-100 print:text-gray-900">
                                    ₹{{ number_format($registration->subtotal, 2) }}
                                </td>
                            </tr>

                            <!-- Discount -->
                            <tr>
                                <td class="p-3 text-gray-200 print:text-gray-900">
                                    Discount ({{ number_format($registration->discount_percentage, 2) }}%)
                                </td>
                                <td class="p-3 text-right text-red-400 print:text-red-600">
                                    -₹{{ number_format($registration->discount_amount, 2) }}
                                </td>
                            </tr>

                            <!-- Final Amount -->
                            <tr class="bg-slate-900 print:bg-gray-50">
                                <td class="p-3 text-lg font-bold text-gray-100 print:text-gray-900">
                                    Final Amount
                                </td>
                                <td class="p-3 text-right text-lg font-bold text-indigo-400 print:text-indigo-600">
                                    ₹{{ number_format($registration->final_amount, 2) }}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <!-- Payment Status -->
                <div class="px-6 pb-6">
                    <div class="border border-slate-700 rounded-lg p-4 bg-slate-900
                                print:bg-gray-50 print:border-gray-300">
                        <div class="flex justify-between">
                            <span class="font-semibold text-gray-300 print:text-gray-700">
                                Payment Status
                            </span>
                            <span class="font-bold uppercase text-gray-100 print:text-gray-900">
                                {{ $registration->payment_status }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions (hidden when printing) -->
                <div class="px-6 pb-6 flex justify-end gap-3 print:hidden">
                    <button onclick="window.print()"
                            class="bg-indigo-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-indigo-700 transition">
                        Print Invoice
                    </button>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>