<x-app-layout>
    <div class="py-12 max-w-3xl mx-auto px-4">
        <div class="bg-white p-8 rounded shadow space-y-6">
            <div class="flex justify-between border-b pb-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Tax Invoice / Receipt</h2>
                    <p class="text-sm text-gray-500">Registration Reference #{{ $registration->id }}</p>
                </div>
                <div>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded font-semibold uppercase text-sm">{{ $registration->payment_status }}</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <h3 class="font-bold text-gray-700">Participant Details:</h3>
                    <p>{{ $registration->participant->name }}</p>
                    <p>{{ $registration->participant->email }}</p>
                    <p>{{ $registration->participant->phone }}</p>
                </div>
                <div>
                    <h3 class="font-bold text-gray-700">Event Details:</h3>
                    <p>{{ $registration->event->title }}</p>
                    <p>Date: {{ \Carbon\Carbon::parse($registration->event->event_date)->format('M d, Y') }}</p>
                </div>
            </div>

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b bg-gray-50 text-xs text-gray-500 uppercase">
                        <th class="p-2">Description</th>
                        <th class="p-2 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y">
                    <tr>
                        <td class="p-2">Event Tickets ({{ $registration->ticket_count }}x)</td>
                        <td class="p-2 text-right">₹{{ $registration->ticket_count * $registration->event->registration_fee }}</td>
                    </tr>
                    @if($registration->workshop_included)
                    <tr>
                        <td class="p-2">Workshop Fee</td>
                        <td class="p-2 text-right">₹50.00</td>
                    </tr>
                    @endif
                    @if($registration->food_included)
                    <tr>
                        <td class="p-2">Food Package</td>
                        <td class="p-2 text-right">₹30.00</td>
                    </tr>
                    @endif
                    <tr class="font-bold bg-gray-50">
                        <td class="p-2">Final Payable Amount</td>
                        <td class="p-2 text-right text-indigo-600">₹{{ $registration->final_amount }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="flex justify-end gap-4 pt-4">
                <button onclick="window.print()" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Print Invoice</button>
            </div>
        </div>
    </div>
</x-app-layout>